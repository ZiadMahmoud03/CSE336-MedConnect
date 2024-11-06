/*-----------------------------------------------------------------Registration Drop Down---------------------------------------------------------*/
function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropdown-toggle')) {
        const dropdownMenu = document.getElementById("dropdownMenu");
        if (dropdownMenu.style.display === "block") {
            dropdownMenu.style.display = "none";
        }
    }
};




/*-----------------------------------------------------------------Sliders---------------------------------------------------------*/
document.addEventListener("DOMContentLoaded", function() {
    const carousel = document.querySelector(".carousel");
    const arrowBtns = document.querySelectorAll(".prev-btn, .next-btn"); 
    const wrapper = document.querySelector(".wrapper");

    const firstCard = carousel.querySelector(".card");
    const firstCardWidth = firstCard.offsetWidth;

    let isDragging = false,
        startX,
        startScrollLeft,
        timeoutId;

    const dragStart = (e) => {
        isDragging = true;
        carousel.classList.add("dragging");
        startX = e.pageX;
        startScrollLeft = carousel.scrollLeft;
    };

    const dragging = (e) => {
        if (!isDragging) return;

        // Calculate the new scroll position
        const newScrollLeft = startScrollLeft - (e.pageX - startX);

        // Prevent dragging beyond carousel boundaries
        if (newScrollLeft <= 0 || newScrollLeft >= carousel.scrollWidth - carousel.offsetWidth) {
            isDragging = false;
            return;
        }

        carousel.scrollLeft = newScrollLeft;
    };

    const dragStop = () => {
        isDragging = false;
        carousel.classList.remove("dragging");
    };

    const autoPlay = () => {
        // Disable autoplay if window width is less than 800px
        if (window.innerWidth < 800) return;

        // Calculate the maximum scroll position
        const maxScrollLeft = carousel.scrollWidth - carousel.offsetWidth;

        // Stop autoplay at the end
        if (carousel.scrollLeft >= maxScrollLeft) return;

        // Autoplay the carousel every 2500ms
        timeoutId = setTimeout(() => {
            carousel.scrollLeft += firstCardWidth;
            autoPlay(); // Continue autoplaying
        }, 2500);
    };

    // Start autoplay on page load
    autoPlay();

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("mousemove", dragging);
    document.addEventListener("mouseup", dragStop);

    // Stop autoplay when mouse is over the wrapper
    wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
    // Resume autoplay when mouse leaves the wrapper
    wrapper.addEventListener("mouseleave", autoPlay);

    // Arrow button functionality for left and right scroll
    arrowBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            carousel.scrollLeft += btn.classList.contains("prev-btn") ? -firstCardWidth : firstCardWidth;
        });
    });
});
