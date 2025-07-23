// import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
// import "./styles/app.css";
import "./styles/app.css";
import "./js/calendar.js";

console.log("✅ App.js chargé avec CSS");

/* 
 ** page index 
 ============== */

window.addEventListener("scroll", function () {
  const header = document.querySelector("header");

  if (window.scrollY > 50) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

/* 
 ** page cart 
 ============== */

document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".flash-close").forEach((button) => {
    button.addEventListener("click", () => {
      button.parentElement.style.display = "none";
    });
  });
});

/* 
 ** page User (modification date rdv) 
 ==================================== */

let currentAppointmentId = null;
let calendarInstance = null;

function openCalendarModal(appointmentId) {
  currentAppointmentId = appointmentId;

  // On affiche l’overlay + la modale
  document.getElementById("calendarOverlay").style.display = "flex";

  const calendarEl = document.getElementById("calendar");

  // Détruire l'ancienne instance si elle existe
  if (calendarInstance) {
    calendarInstance.destroy();
  }

  // Créer une nouvelle instance
  calendarInstance = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: "fr",
    selectable: true,
    events: "/appointments/booked",

    dateClick: function (info) {
      fetch("/appointments/booked/" + info.dateStr)
        .then((res) => res.json())
        .then((takenHours) => {
          showHourSelection(info.dateStr, takenHours);
        })
        .catch((err) => {
          console.error("Erreur récupération créneaux:", err);
          showHourSelection(info.dateStr, []); // fallback = tout dispo
        });
    },
  });

  calendarInstance.render();
}

function showHourSelection(dateStr, takenHours) {
  const allHours = [
    "09:00",
    "10:00",
    "11:00",
    "12:00",
    "13:00",
    "14:00",
    "15:00",
    "16:00",
    "17:00",
  ];

  let hourSelectionHtml = `<h3>Choisir une heure pour le ${dateStr}</h3><ul>`;
  allHours.forEach((hour) => {
    if (takenHours.includes(hour)) {
      hourSelectionHtml += `<li style="color:red">${hour} (réservé)</li>`;
    } else {
      hourSelectionHtml += `<li><button class="update-hour-btn" data-date="${dateStr}" data-hour="${hour}">
      ${hour}</button></li>`;
    }
  });
  hourSelectionHtml += `</ul>`;

  let container = document.getElementById("hourSelection");
  if (!container) {
    container = document.createElement("div");
    container.id = "hourSelection";
    document
      .querySelector("#editAppointmentModal .modal-content")
      .appendChild(container);
  }
  container.innerHTML = hourSelectionHtml;
  container.querySelectorAll(".update-hour-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const date = btn.dataset.date;
      const hour = btn.dataset.hour;
      updateAppointmentDateWithHour(date, hour);
    });
  });
}

function updateAppointmentDateWithHour(dateStr, hour) {
  fetch("/appointment/" + currentAppointmentId + "/update-date", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },
    body: JSON.stringify({ date: dateStr, hour: hour }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("✅ Rendez-vous mis à jour !");
        window.location.reload();
      } else {
        alert("❌ " + (data.error || "Erreur de modification"));
      }
    });
}

// ✅ Initialisation au chargement
document.addEventListener("DOMContentLoaded", () => {
  const overlay = document.getElementById("calendarOverlay");
  const closeBtn = document.querySelector("#editAppointmentModal .close");

  // Boutons "Modifier"
  document.querySelectorAll(".edit-appointment-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      openCalendarModal(id);
    });
  });

  // Fermer sur la croix
  closeBtn.addEventListener("click", closeOverlay);

  // Fermer en cliquant en dehors de la modale
  overlay.addEventListener("click", (e) => {
    if (e.target === overlay) {
      closeOverlay();
    }
  });

  // Fermer avec Échap
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeOverlay();
    }
  });

  function closeOverlay() {
    overlay.style.display = "none";

    // Nettoyage
    const hourSel = document.getElementById("hourSelection");
    if (hourSel) hourSel.innerHTML = "";
  }
});
