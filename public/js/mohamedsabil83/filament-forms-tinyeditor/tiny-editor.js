document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.Livewire === 'undefined' || typeof window.Livewire.hook !== 'function') {
        return;
    }

    const sortableClass = ['fi-fo-builder-item', 'fi-fo-repeater-item'];

    const removeEditors = debounce(() => {
        if (!Array.isArray(window.tinySettingsCopy)) {
            return;
        }

        window.tinySettingsCopy.forEach(i => tinymce.execCommand('mceRemoveEditor', false, i.target.id));
    }, 50);

    const reinitializeEditors = debounce(() => {
        if (!Array.isArray(window.tinySettingsCopy)) {
            return;
        }

        window.tinySettingsCopy.forEach(settings => tinymce.init(settings));
    });

    window.Livewire.hook('morph.updated', (el) => {
        if (!Array.isArray(window.tinySettingsCopy)) {
            return;
        }

        const isModalOpen = document.body.classList.contains('tox-dialog__disable-scroll');
        if (!isModalOpen && sortableClass.some(i => el.el.classList.contains(i))) {
            removeEditors();
            setTimeout(reinitializeEditors, 1);
        }
    });

    function debounce(callback, timeout = 100) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                callback.apply(this, args);
            }, timeout);
        };
    }
});
