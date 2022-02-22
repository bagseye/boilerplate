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
 * Overlay
 *
 */
const overlay = document.querySelector(".overlay");

overlay.addEventListener("click", toggleNavMenu);

/**
 * Assign the submenu toggle functions
 */
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

// ACCORDION
function toggleAccordionItem(ev) {
  const targ = ev.currentTarget;
  const targParent = targ.closest(".accordion__item");
  const targContent = targParent.querySelector(".accordion__content");
  const accordionState = targ.getAttribute("aria-expanded");

  if (accordionState === "true") {
    targ.setAttribute("aria-expanded", "false");
    collapseSection(targContent);
  } else {
    targ.setAttribute("aria-expanded", "true");
    expandSection(targContent);
  }
}

if (accordion.length > 0) {
  const accordionToggles = document.querySelectorAll(".accordion__toggle");

  accordionToggles.forEach((toggle) =>
    toggle.addEventListener("click", toggleAccordionItem)
  );
}

// Height Auto Transitions
function collapseSection(element) {
  // Get the height of the element's inner content, regardless of actual size
  const sectionHeight = element.scrollHeight;

  // Temporarily disable all css transitions
  // Store the element's transition value for use later
  const elementTransition = element.style.transition;
  element.style.transition = "";

  /**
   * On the next frame (as soon as the previous style change has taken effect)
   * Set the element's height to the scroll height value set previously
   * This means we are no longer transitioning 'auto'
   */
  requestAnimationFrame(function () {
    element.style.height = `${sectionHeight}px`;
    element.style.transition = elementTransition;

    /**
     * On the next frame (as soon as thre previous style change has taken effect)
     * Have the element transition to height: 0
     */
    requestAnimationFrame(function () {
      element.style.height = `0px`;
    });
  });

  // Mark the section as collpased (closed)
  element.setAttribute("data-collapsed", "true");
}

function expandSection(element) {
  // Get the height of the element's inner content, regardless of actual size
  const sectionHeight = element.scrollHeight;

  // Have the element transition to the heigiht of its inner content
  element.style.height = `${sectionHeight}px`;

  // When the next css transition finishes
  element.addEventListener("transitionend", function (e) {
    // Remove the event listener so it is only triggered once
    element.removeEventListener("transitionend", arguments.callee);

    // remove 'height' from the element's inline styles, and it returns to it's initial value
    element.style.height = null;
  });

  // Mark the section as not collapsed (open)
  element.setAttribute("data-collapsed", "false");
}

// CLICK COUNTER
jQuery(document).ready(function ($) {
  $("a#download").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: my_ajax_object.ajax_url,
      data: {
        action: "increment_counter",
      },
      type: "POST",
    })
      .done(function () {
        // go to the link they clicked
        // window.location = $(this).attr("href");
        console.log("done");
      })
      .fail(function (xhr) {
        console.log(xhr);
      });
  });
});
