const diplayCountDown = document.getElementById("display-countdown");
const displayDays = document.querySelector(".days");
const displayHours = document.querySelector(".hours");
const displayMinutes = document.querySelector(".minutes");
// set birthday date
let countDownDate = new Date("nov 3, 2023 12:00:00").getTime();

const contentText = document.querySelectorAll(".content");
const iconBtn = document.querySelectorAll(".icon");

const delay = setInterval(() => {
  let now = new Date().getTime();
  const distance = countDownDate - now;

  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor(
    (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Format date
  const d = days === 0 || days === 1 ? `${days} jour` : `${days} jours`;
  const h = hours === 0 || hours === 1 ? `${hours} heure` : `${hours} heures`;
  const m = minutes === 1 ? `${minutes} minute` : `${minutes} minutes`;

  displayDays.innerHTML = `${d}`;
  displayHours.innerHTML = `${h}`;
  displayMinutes.innerHTML = `${m}`;

  if (distance < 0) {
    clearInterval(delay);
    diplayCountDown.innerHTML = "Happy Birthday Denis";
  }
}, 1000);

function showInfos(e) {
  iconBtn.forEach((icon) => {
    icon.addEventListener("click", (e) => {
      let current = document.querySelector(".active");
      // classBlock = e.target.getAttribute("class").slice(11);
      const btnIcon = e.target.dataset.icon;
      const notSelect = document.querySelectorAll(
        ".content:not(." + btnIcon + ")"
      );
      notSelect.forEach((elem) => {
        elem.classList.add("hide");
      });
      e.target.classList.add("active");
      if (current) {
        current.classList.remove("active");
      }
      const select = document.querySelector("." + btnIcon + "");
      select.classList.toggle("hide");
      document.addEventListener("click", (e) => {
        if (e.target !== select && e.target !== icon) {
          select.classList.add("hide");
          icon.classList.remove("active");
        }
      });
    });
  });
}

showInfos();