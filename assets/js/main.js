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
function setCookie(cName, cValue, exp) {
  let date = new Date();
  // Get the time in ms
  date.setTime(date.getTime() + exp * 24 * 60 * 60 * 1000);

  const expires = `expires="${date.toUTCString()}"`;

  document.cookie = `${cName}=${cValue}; ${expires}; path=/`;
}

// GET INFO ABOUT THE COOKIE
function getCookie(cName) {
  const name = `${cName}=`;
  const cDecoded = decodeURIComponent(document.cookie);
  const cArr = cDecoded.split("; ");

  let res;

  cArr.forEach((val) => {
    if (val.indexOf(name) === 0) res = val.substring(name.length);
  });

  return res;
}

// CHECK CURRENT STATE OOF COOKIE
function checkCookie() {
  const cookieBar = document.querySelector(".cookiebar");
  const cookieName = cookieBar.querySelector("button").dataset.cookiename;
  const cookieRes = getCookie(cookieName);

  return cookieRes;
}

// DOM CONTENT LOADED
window.addEventListener("DOMContentLoaded", function () {
  const cookieStatus = checkCookie();

  if (cookieStatus === "accepted") {
    document.querySelector(".cookiebar").classList.add("cookiebar__accepted");
  }
});

// PAGE LOADED
window.addEventListener("load", function () {
  showToast();
});
