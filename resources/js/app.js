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
