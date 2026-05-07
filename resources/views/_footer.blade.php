<footer class="container mb-12 mt-28" data-js-fade-scroll>
    <h6 class="uppercase text-3xl mb-9">Свяжитесь с нами</h6>

    <div class="flex flex-col
    lg:flex-row-reverse lg:justify-between">
        <div class="lg:w-3/5 mb-24 lg:mb-0">
            <div id="js-contact-form"></div>
        </div>
        <div class="lg:w-2/5 lg:pr-24">

            <div class="text-lg mb-8 hidden lg:block">
                Чтобы получить дополнительную информацию, заполните эту форму.
                <br>
                Мы получим ваше сообщение и обязательно свяжемся с вами!
            </div>

            {!! $site_options['footer_contacts'] ?? "" !!}
{{--            <div class="uppercase text-sm mb-4 opacity-50">Социальные сети</div>--}}
{{--            <div class="flex gap-x-12">--}}
{{--                <a href="#" class="hover:underline hover:underline-offset-4">Twitter</a>--}}
{{--                <a href="#" class="hover:underline hover:underline-offset-4">Vkontakte</a>--}}
{{--                <a href="#" class="hover:underline hover:underline-offset-4">Odnoklassniki</a>--}}
{{--            </div>--}}

{{--            <div class="uppercase text-sm mb-4 mt-9 opacity-50">Почта</div>--}}
{{--            <div class="flex gap-x-12">--}}
{{--                <a href="mailto:info@veresk-vandshaft.ru" class="hover:underline hover:underline-offset-4">info@veresk-vandshaft.ru</a>--}}
{{--            </div>--}}
        </div>
    </div>


    {!! $site_options['footer_copyright'] ?? "" !!}
{{--    <div class="flex justify-between align-center text-sm mt-[100px]">--}}
{{--        <div class="opacity-70">©2017-<span id="js-current-year"></span> VERESK. All rights reserved.</div>--}}
{{--        <script type="text/javascript">document.getElementById('js-current-year').innerText = new Date().getFullYear().toString()</script>--}}
{{--        <a href="#" class="underline underline-offset-4 opacity-70 hover:opacity-100">Privacy Policy</a>--}}
{{--    </div>--}}
</footer>
