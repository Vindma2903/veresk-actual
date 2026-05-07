window.addEventListener("scroll", () => {
    const $els = document.querySelectorAll('[data-js-fade-scroll]');
    const windowHeight = window.innerHeight;

    $els.forEach($el => {
        $el.classList.add('js-fade-scroll');
        const elementTop = $el.getBoundingClientRect().top;
        if (elementTop < windowHeight + 50) {
            $el.classList.add('js-fade-scroll--active');
        } else {
            $el.classList.remove('js-fade-scroll--active');
        }
    })
});
