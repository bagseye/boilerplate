const BODY = document.body;
const burger = document.querySelector(".burger");
const subMenuToggles = document.querySelectorAll(".submenu__toggle");
const accordion = document.querySelectorAll(".accordion");
let transitioning = false;

/**
 * Hamburger Toggle
 *
 */
function toggleNavMenu() {
  if (transitioning) return;

  let menuTimer;
  transitioning = true;
  let burgerExpanded = burger.getAttribute("aria-expanded");
  BODY.classList.toggle("menu__open");

  menuTimer = setTimeout(() => {
    if (burgerExpanded === "true") {
      burger.setAttribute("aria-expanded", "false");
      document
        .querySelectorAll(".navigation__hasChildren.open")
        .forEach((submenu) => {
          submenu.classList.remove("open");
          submenu
            .querySelector(".submenu__toggle")
            .setAttribute("aria-expanded", "false");
        });
    } else {
      burger.setAttribute("aria-expanded", "true");
    }
    transitioning = false;
    clearTimeout(menuTimer);
  }, 300);
}

burger.addEventListener("click", toggleNavMenu);

/**
 * Submenu Toggle
 *
 */
function toggleSubMenu(ev) {
  if (!BODY.classList.contains("menu__open")) return;

  const targ = ev.currentTarget;
  let menuState = targ.getAttribute("aria-expanded");

  /**
   * If were clicking on a menu item that is not within an open parent
   * Close the other open menus
   */
  if (!targ.closest(".submenu__parent").classList.contains("open")) {
    subMenuToggles.forEach((toggle) => {
      toggle.closest(".navigation__hasChildren").classList.remove("open");
      toggle.setAttribute("aria-expanded", "false");
    });
  }

  /**
   * If you're clicking on an already open submenu, close it
   * And any open submenus below it
   */
  if (menuState === "true") {
    const targParent = targ.closest(".navigation__hasChildren.open");
    const openSubMenus = targParent.querySelectorAll(
      ".navigation__hasChildren.open"
    );
    // Set the target values to closed state
    targ.setAttribute("aria-expanded", "false");
    targParent.classList.remove("open");
    /**
     * Find all sub menus,
     * If any sub menus are open, set them to a closed state
     */
    if (openSubMenus.length > 0) {
      openSubMenus.forEach((submenu) => {
        submenu.classList.remove("open");
        submenu
          .querySelector(".submenu__toggle")
          .setAttribute("aria-expanded", "false");
      });
    }

    /**
     * Otherwise, open the selected submenu menu
     */
  } else {
    targ.setAttribute("aria-expanded", "true");
    targ.closest(".navigation__hasChildren").classList.add("open");
  }
}

/**
 * Assign the submenu toggle functions
 */
subMenuToggles.forEach((subToggle) => {
  subToggle.addEventListener("click", toggleSubMenu);
});

// ACCORDION
function toggleAccordionItem(ev) {
  const targ = ev.currentTarget;
  const targParent = targ.closest(".accordion__item");
  const accordionState = targ.getAttribute("aria-expanded");

  if (accordionState === "true") {
    targ.setAttribute("aria-expanded", "false");
    targParent.querySelector(".accordion__content").classList.remove("open");
  } else {
    targ.setAttribute("aria-expanded", "true");
    targParent.querySelector(".accordion__content").classList.add("open");
  }
}

if (accordion.length > 0) {
  const accordionToggles = document.querySelectorAll(".accordion__toggle");

  accordionToggles.forEach((toggle) =>
    toggle.addEventListener("click", toggleAccordionItem)
  );
}

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
