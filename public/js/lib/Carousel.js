window.addEventListener('load', () => {
    let carousel = document.querySelector('.carousel');
    let innerCarousel = document.querySelector('.inner-carousel');

    let pressed = false;
    let startX, x;

    carousel.addEventListener('mousedown', (e) => {
        pressed = true;
        startX = e.offsetX - innerCarousel.offsetLeft;
        carousel.style.cursor = "grabbing";
    });

    carousel.addEventListener('mouseenter', () => {
        carousel.style.cursor = "grab";
    });

    carousel.addEventListener('mouseup', () => {
        carousel.style.cursor = 'grab'
    });

    window.addEventListener('mouseup', () => {
        pressed = false;
    });

    carousel.addEventListener('mousemove', (e) => {
        if (!pressed) {return}
        e.preventDefault();
        innerCarousel.style.left = `${e.offsetX - startX}px`;
    })
})
