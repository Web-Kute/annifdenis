document.addEventListener("DOMContentLoaded", (e) => {
  const iconBtn = document.querySelectorAll(".icon");
  const closeCross = document.querySelectorAll(".fa-xmark");
  const navItem = document.querySelectorAll(".nav-item");
  
  const diplayCountDown = document.getElementById("display-countdown");
  const displayDays = diplayCountDown.querySelector(".days");
  const displayHours = diplayCountDown.querySelector(".hours");
  const displayMinutes = diplayCountDown.querySelector(".minutes");
  // set birthday date
  let birthday = new Date("nov 4, 2023 23:59:00").getTime();
  const delay = setInterval(() => {
    let now = new Date().getTime();
    const timeLeft = birthday - now;

    const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
    // const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

    // Format date
    const d = days === 0 || days === 1 ? `${days} jour` : `${days} jours`;
    const h = hours === 0 || hours === 1 ? `${hours} heure` : `${hours} heures`;
    const m =
      minutes === 0 || minutes === 1
        ? `${minutes} minute`
        : `${minutes} minutes`;

    displayDays.textContent = `${d}`;
    displayHours.textContent = `${h}`;
    displayMinutes.textContent = `${m}`;

    if (timeLeft < 0) {
      clearInterval(delay);
      diplayCountDown.textContent = "Happy Birthday Denis";
    }
  }, 1000);

  navItem.forEach((item) => {
    item.addEventListener("click", (e) => {
      let current = document.querySelectorAll(".active");
      const btnIcon = e.target.dataset.icon;
      const notSelect = document.querySelectorAll(
        ".content:not(." + btnIcon + ")"
      );
      notSelect.forEach((elem) => elem.classList.add("hide"));

      current.forEach((item) =>
        item ? item.classList.remove("active") : null
      );

      if (
        e.target.classList.contains("nav-item") ||
        e.target.classList.contains("icon") ||
        e.target.classList.contains("nav-item_text")
      ) {
        for (let index = 0; index < item.children.length; index++) {
          item.children[index].classList.add("active");
        }
      }

      const select = document.querySelector("." + btnIcon + "");
      select.classList.toggle("hide");
      if (select.classList.contains("hide")) {
        for (let index = 0; index < item.children.length; index++) {
          item.children[index].classList.remove("active");
        }
      }
    });
  });

  function hideCounter() {
    isLandscape = window.orientation === 90 || window.orientation === -90;
    isLandscape
      ? diplayCountDown.classList.add("hide")
      : diplayCountDown.classList.remove("hide");
  }

  window.addEventListener("orientationchange", () => {
    hideCounter();
  });

  hideCounter();

  closeCross.forEach((content) => {
    content.addEventListener("click", () => {
      content.closest(".content").classList.add("hide");
      iconBtn.forEach((icon) => {
        icon.classList.remove("active");
        icon.nextElementSibling.classList.remove("active");
      });
    });
  });
});

if (history.scrollRestoration) {
  history.scrollRestoration = "manual";
} else {
  window.onbeforeunload = function () {
    window.scrollTo(0, 0);
  };
}
