import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";

/* 
 ** page index 
 ============== */
// window.addEventListener("scroll", function () {
//   const header = document.querySelector("header");
//   const liArray = document.querySelectorAll("li");

//   if (window.scrollY > 50) {
//     // quand on a scrollé 50px vers le bas
//     header.classList.add("scrolled");
//     liArray.forEach((li) => {
//       li.classList.add("scrolled");
//     });
//   } else {
//     header.classList.remove("scrolled");
//     liArray.forEach((li) => {
//       li.classList.remove("scrolled");
//     });
//   }
// });
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
