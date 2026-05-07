const $collapseButtons = document.querySelectorAll('button[data-collapse-id]');
$collapseButtons.forEach($btn => {
    $btn.addEventListener('click', e => {
        const id = $btn.getAttribute('data-collapse-id');
        const $el = document.getElementById(id);
        if ($el) {
            if ($el.classList.contains('hidden')) {
                $el.classList.remove('hidden');
            } else {
                $el.classList.add('hidden');
            }
        }
    })
})
