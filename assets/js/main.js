const BODY = document.body;
const burger = document.querySelector(".burger");
const subMenuToggles = document.querySelectorAll(".submenu__toggle");
const accordion = document.querySelectorAll(".accordion");
const videoBlocks = document.querySelectorAll(".videoblock");
let transitioning = false;

// (function () {
//   /**
//    * Menu Toggle Behaviors
//    *
//    *
//    */

//   	var navMenu = function (id) {
//       var wrapper = document.body, // this is the element to which a CSS class is added when a mobile nav menu is open
//         mobileButton = document.getElementById(id + "-mobile-menu"),
//         navMenuEl = document.getElementById("site-navigation");

//       // If there's no nav menu, none of this is necessary.
//       if (!navMenuEl) {
//         return;
//       }

//       if (mobileButton) {
//         mobileButton.onclick = function () {
//           wrapper.classList.toggle(id + "-navigation-open");
//           wrapper.classList.toggle("lock-scrolling");
//           twentytwentyoneToggleAriaExpanded(mobileButton);
//           mobileButton.focus();
//         };
//       }

//       /**
//        * Trap keyboard navigation in the menu modal.
//        * Adapted from Twenty Twenty.
//        *
//        * @since Twenty Twenty-One 1.0
//        */
//       document.addEventListener("keydown", function (event) {
//         var modal,
//           elements,
//           selectors,
//           lastEl,
//           firstEl,
//           activeEl,
//           tabKey,
//           shiftKey,
//           escKey;
//         if (!wrapper.classList.contains(id + "-navigation-open")) {
//           return;
//         }

//         modal = document.querySelector("." + id + "-navigation");
//         selectors = "input, a, button";
//         elements = modal.querySelectorAll(selectors);
//         elements = Array.prototype.slice.call(elements);
//         tabKey = event.keyCode === 9;
//         shiftKey = event.shiftKey;
//         escKey = event.keyCode === 27;
//         activeEl = document.activeElement; // eslint-disable-line @wordpress/no-global-active-element
//         lastEl = elements[elements.length - 1];
//         firstEl = elements[0];

//         if (escKey) {
//           event.preventDefault();
//           wrapper.classList.remove(id + "-navigation-open", "lock-scrolling");
//           twentytwentyoneToggleAriaExpanded(mobileButton);
//           mobileButton.focus();
//         }

//         if (!shiftKey && tabKey && lastEl === activeEl) {
//           event.preventDefault();
//           firstEl.focus();
//         }

//         if (shiftKey && tabKey && firstEl === activeEl) {
//           event.preventDefault();
//           lastEl.focus();
//         }

//         // If there are no elements in the menu, don't move the focus
//         if (tabKey && firstEl === lastEl) {
//           event.preventDefault();
//         }
//       });

//       /**
//        * Close menu and scroll to anchor when an anchor link is clicked.
//        * Adapted from Twenty Twenty.
//        *
//        * @since Twenty Twenty-One 1.1
//        */
//       document.addEventListener("click", function (event) {
//         // If target onclick is <a> with # within the href attribute
//         if (event.target.hash && event.target.hash.includes("#")) {
//           wrapper.classList.remove(id + "-navigation-open", "lock-scrolling");
//           twentytwentyoneToggleAriaExpanded(mobileButton);
//           // Wait 550 and scroll to the anchor.
//           setTimeout(function () {
//             var anchor = document.getElementById(event.target.hash.slice(1));
//             if (anchor) {
//               anchor.scrollIntoView();
//             }
//           }, 550);
//         }
//       });

//       navMenuEl
//         .querySelectorAll(".menu-wrapper > .menu-item-has-children")
//         .forEach(function (li) {
//           li.addEventListener("mouseenter", function () {
//             this.querySelector(".sub-menu-toggle").setAttribute(
//               "aria-expanded",
//               "true"
//             );
//             twentytwentyoneSubmenuPosition(li);
//           });
//           li.addEventListener("mouseleave", function () {
//             this.querySelector(".sub-menu-toggle").setAttribute(
//               "aria-expanded",
//               "false"
//             );
//           });
//         });
//     };

//   window.addEventListener("load", function () {
//     new navMenu("primary");
//   });
// })();

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
      url: boilerplate_params.ajax_url,
      data: {
        action: "increment_counter",
      },
      type: "POST",
    })
      .done(function () {
        // go to the link they clicked
        $("#mydiv").load(location.href + " #mydiv");
      })
      .fail(function (xhr) {
        console.log(xhr);
      });
  });
});

// MODAL POST
jQuery(function ($) {
  $("body").on("click", ".view-post", function () {
    var data = {
      action: "load_post_by_ajax",
      id: $(this).data("id"),
      security: boilerplate_params.security,
    };

    $.post(boilerplate_params.ajax_url, data, function (response) {
      response = JSON.parse(response);
      $("#postModal h5#postModalLabel").text(response.title);
      $("#postModal .modal__body").html(response.content);
    });
  });
});

// function validateEmail(email) {
//   var re = /\S+@\S+\.\S+/;
//   return re.test(email);
// }

// const commentForm = document.querySelector("#commentform");

// if (commentForm) {
//   const commentSubmit = commentForm.querySelector("#submit");

//   console.log(commentSubmit);
//   commentSubmit.addEventListener("click", function (ev) {
//     ev.preventDefault();
//     const emailInput = commentForm.querySelector("#email");

//     const isEmail = validateEmail(emailInput.value);

//     console.log(isEmail);
//   });
//   // commentSubmit.preventDefault();
// }

/**
 * VIDEO OBSERVER
 * Swaps video source from data-src to src when intersecting
 * Good for YouTube embeds and PageSpeed
 */
// const videoObserver = new IntersectionObserver((entries, observer) => {
//   entries.forEach((entry) => {
//     const videoTarg = entry.target.querySelector(".videoblock__video");
//     entry.isIntersecting ? videoTarg.play() : videoTarg.pause();
//   });
// });

// window.addEventListener("DOMContentLoaded", function () {
//   if (videoBlocks.length > 0) {
//     videoBlocks.forEach((videoBlock) => videoObserver.observe(videoBlock));
//   }
// });

function videoPlaceholderPlay(ev, videoBlock) {
  const video = videoBlock.querySelector(".videoblock__video");
  // video.src += "?autoplay=1";
  video.src = `${video.dataset.videoSrc}?autoplay=1`;
  ev.target.style.display = "none";
}

if (videoBlocks.length > 0) {
  videoBlocks.forEach((videoBlock) => {
    const videoPlaceholder = videoBlock.querySelector(
      ".videoblock__placeholder"
    );

    videoPlaceholder.addEventListener("click", (targ) =>
      videoPlaceholderPlay(targ, videoBlock)
    );
  });
}
