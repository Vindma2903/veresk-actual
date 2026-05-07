import theme from 'tailwindcss/defaultTheme.js';
const isDesktop = window.innerWidth >= theme.screens.lg.replace('px', '');

const treeMenuWrapper = document.getElementById('js-tree-menu');
if (treeMenuWrapper) {
    const btnEls = treeMenuWrapper.querySelectorAll('button[type="button"]');
    const $rootLiEls = treeMenuWrapper.querySelectorAll('&>ul>li');
    function removeActiveFromAllLi() {
        // если был активный, то убираем его, чтобы был аккордеон
        for (const child of $rootLiEls) {
            if (child.classList.contains('active')) {
                child.classList.remove('active');
            }
        }
    }
    btnEls.forEach(el => {
        el.addEventListener('click', () => {
            const liEl = el.closest('li');
            if (liEl.classList.contains('active')) {
                liEl.classList.remove('active');
            } else {
                removeActiveFromAllLi();
                liEl.classList.add('active');
            }
        })
    })
}
