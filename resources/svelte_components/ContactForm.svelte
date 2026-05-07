<script>
    import FormErrorFor from './FormErrorFor.svelte';

    let model = {
        name: '',
        email: '',
        phone: '',
        now: '',
    }
    let isSending = false;
    let isSuccess = false;
    let errors = {};
    setModelNow();

    function setModelNow() {
        model.now = Math.round(new Date().getTime() / 1000);
    }

    function handleSubmit()
    {
        if (isSending) return;
        isSending = true;
        fetch('/notify-send', {
            method: "POST",
            body: JSON.stringify(model),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        }).then((response) => response.json())
            .then(resp => {
                if (typeof resp === 'object' && resp.hasOwnProperty('status')) {
                    if (resp['status'] === 'ok') {
                        errors = {};
                        isSuccess = true;
                        Object.keys(model).forEach(key => {
                            model[key] = '';
                        })
                        setModelNow();
                        if (window.hasOwnProperty('ym') && window.ym) {
                            window.ym(38063405,'reachGoal','FormaSvyaziMetrika');
                        }
                    } else if (resp['status'] === 'error' && resp.hasOwnProperty('errors')) {
                        if (typeof resp['errors'] === 'object') {
                            errors = resp['errors'];
                        }
                    }
                }
            })
            .finally(() => isSending = false);
    }

</script>
<form on:submit|preventDefault={handleSubmit}>
    <div class="flex flex-col gap-y-2.5 lg:gap-y-5 mb-5">
        <input type="text" bind:value={model.name} placeholder="Имя *" class="placeholder-opacity-50 border-b border-white bg-transparent text-xl py-5 lg:py-1.5" required="required"/>
        <FormErrorFor errors="{errors}" key="name"/>
        <input type="text" bind:value={model.phone} placeholder="Телефон *" class="placeholder-opacity-50 border-b border-white bg-transparent text-xl py-5 lg:py-1.5" required="required"/>
        <FormErrorFor errors="{errors}" key="phone"/>
        <input type="email" bind:value={model.email} placeholder="E-mail *" class="placeholder-opacity-50 border-b border-white bg-transparent text-xl py-5 lg:py-1.5" required="required"/>
        <FormErrorFor errors="{errors}" key="email"/>
    </div>

    <div class="mb-2.5 bg-[#7D9B73] p-5" class:hidden="{!isSuccess}">
        <i class="las la-check-circle la-lg mr-1"></i>
        <strong class="font-medium">Благодарим Вас за обращение!</strong> Мы свяжемся с Вами в ближайшее время.
    </div>
    <button type="submit"
            class="mt-8 h-[46px] leading-[44px] bg-white text-black text-xl hover:bg-gray-200 active:bg-gray-300 w-full px-8 sm:w-auto lg:mt-5">
        Отправить
    </button>

    <div class="text-sm opacity-50 mt-4" disabled="{isSending}">Нажимая кнопку “Отправить”, я даю согласие на обработку персональных данных.</div>
</form>
