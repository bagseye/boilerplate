const BODY = document.body;
const burger = document.querySelector(".burger");
const subMenuToggles = document.querySelectorAll(".submenu__toggle");
let transitioning = false;

/**
 * Hamburger Toggle
 *
 *
 */
function toggleNavMenu() {
  if (transitioning) return;

  let menuTimer;
  transitioning = true;
  let burgerExpanded = burger.getAttribute("aria-expanded");
  BODY.classList.toggle("menu__open");

  menuTimer = setTimeout(() => {
    burgerExpanded === "true"
      ? burger.setAttribute("aria-expanded", "false")
      : burger.setAttribute("aria-expanded", "true");
    transitioning = false;
    clearTimeout(menuTimer);
  }, 300);
}

burger.addEventListener("click", toggleNavMenu);

/**
 * Submenu Toggle
 *
 *
 */
function toggleSubMenu(ev) {
  const targ = ev.currentTarget;
  BODY.classList.toggle("submenu__open");
  let submenuExpanded = targ.getAttribute("aria-expanded");

  submenuExpanded === "true"
    ? targ.setAttribute("aria-expanded", "false")
    : targ.setAttribute("aria-expanded", "true");
}

subMenuToggles.forEach((subToggle) => {
  subToggle.addEventListener("click", toggleSubMenu);
});

// TOAST
// SHOW THE TOAST MESSAGE
function showToast() {
  const toast = document.querySelector(".toast");

  if (!toast) return;

  const currentSession = window.sessionStorage.getItem("toast");

  if (currentSession !== "accepted") {
    const toastShowTimeout = setTimeout(function () {
      toast.classList.add("toast__show");
      toast
        .querySelector("button")
        .addEventListener("click", closeToast, { once: true });
      clearTimeout(toastShowTimeout);
    }, 5000);
  }
}

// CLOSE THE TOAST MESSAGE
function closeToast(ev) {
  ev.currentTarget.closest(".toast").classList.remove("toast__show");
  window.sessionStorage.setItem("toast", "accepted");
}

// COOKIE
//SET THE COOKIE
function setCookieAccept(ev, cValue) {
  const { expires, cookiename } = ev.dataset;

  let date = new Date();
  date.setTime(date.getTime() + expires * 24 * 60 * 60 * 1000);
  const expireString = `expires="${date.toUTCString()}"`;
  document.cookie = `${cookiename}=${cValue}; ${expireString}; path=/`;

  ev.closest(".cookiebar").classList.add("cookiebar__accepted");
}

// CHECK FOR COOKIE
function checkForCookie(cName) {
  const name = `${cName}=`;
  const cDecoded = decodeURIComponent(document.cookie);
  const cArr = cDecoded.split(";");

  let res;

  cArr.forEach((val) => {
    if (val.includes(name)) res = true;
  });

  return res;
}

// DOM CONTENT LOADED
window.addEventListener("DOMContentLoaded", function () {
  const cookieBar = document.querySelector(".cookiebar");
  const cookieName = cookieBar.querySelector("button").dataset.cookiename;
  const cookieRes = checkForCookie(cookieName);

  if (cookieRes) {
    document.querySelector(".cookiebar").classList.add("cookiebar__accepted");
  }
});

function startTestimonials() {
  const testimonials = document.querySelectorAll("testimonial");

  if (!testimonials) return;

  testimonials.forEach((testimonial) => {
    new Splide(testimonial).mount();
  });
}

// PAGE LOADED
window.addEventListener("load", function () {
  showToast();

  var elms = document.getElementsByClassName("splide");

  for (var i = 0; i < elms.length; i++) {
    new Splide(elms[i]).mount();
  }
});

window.addEventListener("load", function () {
  startTestimonials();
});
