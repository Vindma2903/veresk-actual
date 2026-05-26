import '../css/app.css';
import '../css/misc.css';
import 'line-awesome/dist/line-awesome/css/line-awesome.min.css';
import '../css/_entry_content.scss';
import '../css/_tree_menu.scss';
import '../css/_admin_panel.scss';

import './bootstrap';
import './_horizontail-scroll-wheel';
import './_sidebar_tree.js';
import './_link_img_modal.js';
import './_collapse_hidden.js';
import './_scroll_fade.js';

import HeaderCollapseButton from './../svelte_components/HeaderCollapseButton.svelte';
import ServiceSlider from './../svelte_components/ServiceSlider.svelte';
import ContactForm from './../svelte_components/ContactForm.svelte';

const $contactForm = document.getElementById('js-contact-form');
if ($contactForm) new ContactForm({
    target: $contactForm,
})

const $headerCollapseButton = document.getElementById('js-header-collapse-button');
if ($headerCollapseButton) new HeaderCollapseButton({
    target: $headerCollapseButton,
    props: {
        menu_items: JSON.parse($headerCollapseButton.dataset.menu_items),
        menu_contacts: JSON.parse($headerCollapseButton.dataset.menu_contacts),
    }
})
const $serviceSlider = document.getElementById('js-service-slider');
// console.log(window.service_slider_data);
if ($serviceSlider) new ServiceSlider({
    target: $serviceSlider,
    props: {
        title: $serviceSlider.dataset.title,
        image: $serviceSlider.dataset.image,
        services: window.service_slider_data ? JSON.parse(window.service_slider_data) : [],
    }
})

const $jsFullYear = document.getElementById('js-current-year');
if ($jsFullYear) {
    $jsFullYear.innerText = new Date().getFullYear().toString();
}

// Interactive hotspots on landscape design page
document.addEventListener('DOMContentLoaded', () => {
    const isLandshaftPage = window.location.pathname === '/services/landshaftnoe-proektirovanie'
        || window.location.pathname === '/landshaftnoe-proektirovanie';
    const contactForm = document.getElementById('js-contact-form');

    if (isLandshaftPage && contactForm) {
        const normalize = (value) => (value || '')
            .toLowerCase()
            .replace(/\s+/g, ' ')
            .trim();

        const ctaPhrases = ['рассчитать стоимость', 'заказать проект', 'заказать прямо сейчас'];

        // Delegated handler: also covers buttons/links injected from CMS HTML.
        document.addEventListener('click', (event) => {
            const target = event.target instanceof Element ? event.target.closest('a, button') : null;
            if (!target) {
                return;
            }

            const text = normalize(target.textContent);
            if (!ctaPhrases.some((phrase) => text.includes(phrase))) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();
            contactForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    if (isLandshaftPage) {
        const cardLinkMap = [
            { image: '/img/999.jpg', url: '/services/blagoustrojstvo-dachnogo-uchastka' },
            { image: '/img/paving_paths_img.png', url: '/services/moshhenie-dorozhek' },
            { image: '/img/retaining_walls.png', url: '/services/podpornye-stenki' },
            { image: '/img/888.jpg', url: '/services/ozelenenie-uchastka' },
            { image: '/img/garden_maintenance_img.png', url: '/services/ukhod-za-sadom' },
            { image: '/img/cleaning_ponds_img.png', url: '/services/ochistka-prudov' },
        ];

        cardLinkMap.forEach(({ image, url }) => {
            const cardImage = document.querySelector(`[style*="${image}"]`);
            if (!(cardImage instanceof Element)) {
                return;
            }

            const card = cardImage.closest('a, article, div');
            if (!(card instanceof Element)) {
                return;
            }

            if (card.tagName === 'A') {
                card.setAttribute('href', url);
                return;
            }

            const nestedAnchor = card.querySelector('a');
            if (nestedAnchor) {
                nestedAnchor.setAttribute('href', url);
                return;
            }

            card.style.cursor = 'pointer';
            card.addEventListener('click', () => {
                window.location.href = url;
            });
            card.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    window.location.href = url;
                }
            });
            if (!card.hasAttribute('tabindex')) {
                card.setAttribute('tabindex', '0');
            }
        });

        const portfolioCardLinkMap = [
            { image: '/img/Rectangle%2015.png', url: '/portfolio/moon-lake' },
            { image: '/img/Rectangle%2016.png', url: '/portfolio/vodnyi-mir' },
            { image: '/img/Rectangle%2017.png', url: '/portfolio/ligolambi' },
            { image: '/img/Rectangle%2018.png', url: '/portfolio/suxodole' },
        ];

        portfolioCardLinkMap.forEach(({ image, url }) => {
            const cardImage = document.querySelector(`img[src*="${image}"]`);
            if (!(cardImage instanceof Element)) {
                return;
            }

            const card = cardImage.closest('a, article, div');
            if (!(card instanceof Element)) {
                return;
            }

            if (card.tagName === 'A') {
                card.setAttribute('href', url);
                return;
            }

            const nestedAnchor = card.querySelector('a');
            if (nestedAnchor) {
                nestedAnchor.setAttribute('href', url);
                return;
            }

            card.style.cursor = 'pointer';
            card.addEventListener('click', () => {
                window.location.href = url;
            });
            card.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    window.location.href = url;
                }
            });
            if (!card.hasAttribute('tabindex')) {
                card.setAttribute('tabindex', '0');
            }
        });
    }

    const area = document.querySelector('[data-hotspot-area="landshaft"]');
    if (!area) {
        return;
    }

    const tooltip = area.querySelector('[data-hotspot-tooltip]');
    if (!tooltip) {
        return;
    }

    const imageEl = tooltip.querySelector('[data-hotspot-image]');
    const captionEl = tooltip.querySelector('[data-hotspot-caption]');
    const closeBtn = tooltip.querySelector('[data-hotspot-close]');

    const openTooltip = (btn) => {
        const img = btn.getAttribute('data-image');
        const caption = btn.getAttribute('data-caption');

        if (imageEl && img) {
            imageEl.src = img;
        }
        if (captionEl && caption) {
            captionEl.textContent = caption;
        }

        tooltip.classList.remove('hidden');
    };

    area.querySelectorAll('[data-hotspot-button]').forEach((btn) => {
        btn.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            openTooltip(btn);
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            tooltip.classList.add('hidden');
        });
    }

    area.addEventListener('click', () => {
        tooltip.classList.add('hidden');
    });
});
