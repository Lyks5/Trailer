document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector(".slider");
    const slides = document.querySelectorAll(".slider img");
    const prevButton = document.querySelector(".prev");
    const nextButton = document.querySelector(".next");
    const indicators = document.querySelectorAll(".indicator");
    let currentIndex = 0;
    function showSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
        indicators.forEach((indicator, i) =>
            indicator.classList.toggle("active", i === index)
        );
    }
    prevButton.addEventListener("click", () =>
        showSlide(
            (currentIndex = (currentIndex - 1 + slides.length) % slides.length)
        )
    );
    nextButton.addEventListener("click", () =>
        showSlide((currentIndex = (currentIndex + 1) % slides.length))
    );
    indicators.forEach((indicator, i) =>
        indicator.addEventListener("click", () => showSlide((currentIndex = i)))
    );
    setInterval(
        () => showSlide((currentIndex = (currentIndex + 1) % slides.length)),
        5000
    );
});
