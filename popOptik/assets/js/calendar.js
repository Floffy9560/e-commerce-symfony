// FullCalendar :
// import { Calendar } from "@fullcalendar/core";
// import dayGridPlugin from "@fullcalendar/daygrid";
// import listPlugin from "@fullcalendar/list";
// import interactionPlugin from "@fullcalendar/interaction";
// import frLocale from "@fullcalendar/core/locales/fr";
// import "preact";
// import "preact/compat";

// document.addEventListener("DOMContentLoaded", function () {
//   const calendarEl = document.getElementById("calendar");
//   const selectedDateEl = document.getElementById("selected-date");
//   const slotsContainer = document.getElementById("available-slots");
//   const confirmBtn = document.getElementById("confirm-btn");

//   let chosenDate = null;
//   let chosenHour = null;

//   const possibleSlots = [
//     "10:00",
//     "10:30",
//     "11:00",
//     "11:30",
//     "14:00",
//     "14:30",
//     "15:00",
//     "15:30",
//     "16:00",
//     "16:30",
//     "17:00",
//     "17:30",
//   ];

//   const calendar = new Calendar(calendarEl, {
//     plugins: [dayGridPlugin, listPlugin, interactionPlugin],
//     initialView: window.innerWidth < 768 ? "listWeek" : "dayGridMonth",
//     locale: frLocale,
//     height: "auto",
//     validRange: {
//       start: new Date().toISOString().split("T")[0],
//     },
//     windowResize: function () {
//       if (window.innerWidth < 768) {
//         calendar.changeView("listWeek");
//       } else {
//         calendar.changeView("dayGridMonth");
//       }
//     },
//     selectable: true,
//     businessHours: {
//       daysOfWeek: [1, 2, 3, 4, 5],
//       startTime: "10:00",
//       endTime: "18:00",
//     },
//     hiddenDays: [0, 6],
//     events: "/appointment/events",

//     eventDidMount: function (info) {
//       info.el.classList.add("fc-event-reserved");
//     },

//     dateClick: function (info) {
//       chosenDate = info.dateStr;
//       selectedDateEl.textContent = chosenDate;
//       confirmBtn.style.display = "none";

//       fetch("/appointment/events")
//         .then((response) => response.json())
//         .then((events) => {
//           const bookedSlots = events
//             .filter((e) => e.start.startsWith(chosenDate))
//             .map((e) => e.start.substring(11, 16));

//           slotsContainer.innerHTML = "";
//           possibleSlots.forEach((slot) => {
//             const btn = document.createElement("button");
//             btn.textContent = slot;

//             if (bookedSlots.includes(slot)) {
//               btn.disabled = true;
//               btn.textContent += " (réservé)";
//             } else {
//               btn.addEventListener("click", () => {
//                 chosenHour = slot;
//                 document
//                   .querySelectorAll("#available-slots button")
//                   .forEach((b) => (b.style.outline = ""));
//                 btn.style.outline = "3px solid #28a745";
//                 confirmBtn.style.display = "inline-block";
//               });
//             }
//             slotsContainer.appendChild(btn);
//           });
//         });
//     },
//   });

//   calendar.render();

//   confirmBtn.addEventListener("click", () => {
//     if (!chosenDate || !chosenHour) return;

//     if (
//       confirm(
//         `Voulez-vous confirmer le rendez-vous le ${chosenDate} à ${chosenHour} ?`
//       )
//     ) {
//       window.location.href = `/appointment/book/${chosenDate}/${chosenHour}`;
//     }
//   });
// });

document.addEventListener("DOMContentLoaded", function () {
  const calendarEl = document.getElementById("calendar");
  const selectedDateEl = document.getElementById("selected-date");
  const slotsContainer = document.getElementById("available-slots");
  const confirmBtn = document.getElementById("confirm-btn");

  let chosenDate = null;
  let chosenHour = null;

  const possibleSlots = [
    "10:00",
    "10:30",
    "11:00",
    "11:30",
    "14:00",
    "14:30",
    "15:00",
    "15:30",
    "16:00",
    "16:30",
    "17:00",
    "17:30",
  ];

  const calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [
      FullCalendar.DayGrid.default,
      FullCalendar.Interaction.default,
      FullCalendar.List.default,
    ],
    initialView: window.innerWidth < 768 ? "listWeek" : "dayGridMonth",
    locale: "fr",
    height: "auto",
    validRange: {
      start: new Date().toISOString().split("T")[0],
    },
    windowResize: function () {
      if (window.innerWidth < 768) {
        calendar.changeView("listWeek");
      } else {
        calendar.changeView("dayGridMonth");
      }
    },
    selectable: true,
    businessHours: {
      daysOfWeek: [1, 2, 3, 4, 5],
      startTime: "10:00",
      endTime: "18:00",
    },
    hiddenDays: [0, 6],
    events: "/appointment/events",

    eventDidMount: function (info) {
      info.el.classList.add("fc-event-reserved");
    },

    dateClick: function (info) {
      chosenDate = info.dateStr;
      selectedDateEl.textContent = chosenDate;
      confirmBtn.style.display = "none";

      fetch("/appointment/events")
        .then((response) => response.json())
        .then((events) => {
          const bookedSlots = events
            .filter((e) => e.start.startsWith(chosenDate))
            .map((e) => e.start.substring(11, 16));

          slotsContainer.innerHTML = "";
          possibleSlots.forEach((slot) => {
            const btn = document.createElement("button");
            btn.textContent = slot;

            if (bookedSlots.includes(slot)) {
              btn.disabled = true;
              btn.textContent += " (réservé)";
            } else {
              btn.addEventListener("click", () => {
                chosenHour = slot;
                document
                  .querySelectorAll("#available-slots button")
                  .forEach((b) => (b.style.outline = ""));
                btn.style.outline = "3px solid #28a745";
                confirmBtn.style.display = "inline-block";
              });
            }
            slotsContainer.appendChild(btn);
          });
        });
    },
  });

  calendar.render();

  confirmBtn.addEventListener("click", () => {
    if (!chosenDate || !chosenHour) return;

    if (
      confirm(
        `Voulez-vous confirmer le rendez-vous le ${chosenDate} à ${chosenHour} ?`
      )
    ) {
      window.location.href = `/appointment/book/${chosenDate}/${chosenHour}`;
    }
  });
});
