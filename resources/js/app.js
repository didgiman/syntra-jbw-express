/*
* Animation for mobile menu
* - Slide down when opened
* - Slide up when closed
* - Fade in when opened
* - Fade out when closed
*/
let isOpen = false;
document.querySelector('#hamburger').addEventListener('click', function () {
    const menu = document.querySelector('#mobile-menu');

    if (isOpen) {
        menu.classList.remove("animate-slide-down");
        menu.classList.add("animate-slide-up");
        setTimeout(() => {
            menu.classList.add("opacity-0");
        }, 200); // Matches the slide-up duration
    } else {
        menu.classList.remove("animate-slide-up", "opacity-0");
        menu.classList.add("animate-slide-down");
    }
    isOpen = !isOpen;
});