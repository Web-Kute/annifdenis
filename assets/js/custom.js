const diplayCountDown = document.getElementById("display-countdown");
const displayDays = diplayCountDown.querySelector(".days");
const displayHours = diplayCountDown.querySelector(".hours");
const displayMinutes = diplayCountDown.querySelector(".minutes");
// set birthday date
let countDownDate = new Date("nov 4, 2023 23:59:00").getTime();

const contentText = document.querySelectorAll(".content");
const iconBtn = document.querySelectorAll(".icon");
const picture = document.querySelector(".info-pic");

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
  const m =
    minutes === 0 || minutes === 1 ? `${minutes} minute` : `${minutes} minutes`;

  displayDays.textContent = `${d}`;
  displayHours.textContent = `${h}`;
  displayMinutes.textContent = `${m}`;

  if (distance < 0) {
    clearInterval(delay);
    diplayCountDown.textContent = "Happy Birthday Denis";
  }
}, 1000);

function showInfos(e) {
  iconBtn.forEach((icon) => {
    icon.addEventListener("click", (e) => {
      const btnIcon = e.target.dataset.icon;
      const notSelect = document.querySelectorAll(
        ".content:not(." + btnIcon + ")"
      );
      notSelect.forEach((elem) => {
        elem.classList.add("hide");
      });

      e.target.classList.toggle("active");
      
      const select = document.querySelector("." + btnIcon + "");
      select.classList.toggle("hide");
      document.addEventListener("click", (e) => {
        if (e.target !== select && e.target !== icon && e.target !== picture) {
          select.classList.add("hide");
          icon.classList.remove("active");
        }
        e.stopPropagation();
      });
    });
  });
}

showInfos();

window.addEventListener("orientationchange", () => {
  isLandscape = window.orientation === 90 || window.orientation === -90;
  isLandscape
    ? (diplayCountDown.style.display = "none")
    : (diplayCountDown.style.display = "block");
});
