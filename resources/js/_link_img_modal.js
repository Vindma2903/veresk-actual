const $linkImageModalEls = document.querySelectorAll('.js-modal-images a>img');
const $modalContainer = document.getElementById('js-image-modal');
if ($modalContainer) {
    const $modalCloseBtn = $modalContainer.querySelector('button');
    const $modalImage = $modalContainer.querySelector('img');

    $modalContainer.addEventListener('click', e => {
        closeModal();
    })

    document.addEventListener('keydown', evt => {
        if (evt.key === 'Escape') {
            closeModal();
        }
    });

    $linkImageModalEls.forEach($imgEl => {
        const $aEl = $imgEl.parentNode;
        $aEl.addEventListener('click', e => {
            e.preventDefault();
            openModal($aEl.href);
        })
    })

    function closeModal()
    {
        $modalContainer.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openModal(imgSrc) {
        $modalImage.src = imgSrc;
        $modalContainer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}
