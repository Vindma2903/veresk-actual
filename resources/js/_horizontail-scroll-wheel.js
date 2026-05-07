const scrollContainers = document.querySelectorAll("[data-js-horizontal-scroll-wheel]");

scrollContainers.forEach(mySlider => {
    let isDown = false;
    let startX;
    let scrollLeft;

    mySlider.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - mySlider.offsetLeft;
        scrollLeft = mySlider.scrollLeft;
    });
    mySlider.addEventListener('mouseleave', () => {
        isDown = false;
    });
    mySlider.addEventListener('mouseup', () => {
        isDown = false;
    });
    mySlider.addEventListener('mousemove', (e) => {
        if(!isDown) return;
        e.preventDefault();
        const x = e.pageX - mySlider.offsetLeft;
        const walk = (x - startX); //scroll-fast
        mySlider.scrollLeft = scrollLeft - walk;
    });
})
