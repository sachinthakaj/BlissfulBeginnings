let currentSlide = "mission";

function nextSlide() {
    if (currentSlide === "mission") {
        document.getElementById("mission").style.display = "none";
        document.getElementById("vision").style.display = "block";
        currentSlide = "vision";
    } else {
        document.getElementById("vision").style.display = "none";
        document.getElementById("mission").style.display = "block";
        currentSlide = "mission";
    }
}

function prevSlide() {
    nextSlide(); // Toggle for both directions since there are only two slides.
}
