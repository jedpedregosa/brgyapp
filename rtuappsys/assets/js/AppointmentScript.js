// RTU APPOINTMENT SYSTEM
const slidePage = document.querySelector(".slide-page"); // important for flipping next
const nextBtnFirst = document.querySelector(".firstNext"); // first next button
const prevBtnSec = document.querySelector(".prev-1"); // calendar previous button
const nextBtnSec = document.querySelector(".next-1"); // calendar next button
const prevBtnThird = document.querySelector(".prev-2"); // personal previous button
const nextBtnThird = document.querySelector(".next-2"); // personal next button
const prevBtnFourth = document.querySelector(".prev-3"); // confirmation previous button
const submitBtn = document.querySelector(".submit"); // confirm button 
const progressCheck = document.querySelectorAll(".step .check");
const bullet = document.querySelectorAll(".step .bullet");
let current = 1;

nextBtnFirst.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "-25%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    current += 1;
});
nextBtnSec.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "-50%";
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    current += 1;
});

submitBtn.addEventListener("click", function() {
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    current += 1;
});
prevBtnSec.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "0%";
    bullet[current - 2].classList.remove("active");
    progressCheck[current - 2].classList.remove("active");
    current -= 1;
});
prevBtnThird.addEventListener("click", function(event) {
    event.preventDefault();
    slidePage.style.marginLeft = "-25%";
    bullet[current - 2].classList.remove("active");
    progressCheck[current - 2].classList.remove("active");
    current -= 1;
});