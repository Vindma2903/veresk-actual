@extends('base')

@php
$contactTypes = [
    ['title' => 'Адрес', 'description' => 'Санкт Петербург, 13 линия В.О., 6-8 а'],
    ['title' => 'Email', 'description' => 'info@veresk-landshaft.ru'],
    ['title' => 'Телефон', 'description' => '+7 (812) 905-18-63, +7 (921) 905-18-63'],
]
@endphp

@section('main')
    <div class="container">
        <div class="flex flex-col gap-14 lg:flex-row lg:gap-0 lg:justify-between">
            <div>
                <div class="font-helvetica text-4xl sm:text-[40px] mb-2.5">Адрес</div>
                <div class="sm:text-xl">Санкт Петербург, 13 линия В.О., 6-8 а</div>
            </div>
            <div>
                <div class="font-helvetica text-4xl sm:text-[40px] mb-2.5">Email</div>
                <div class="sm:text-xl">
                    <a href="mailto:info@veresk-landshaft.ru" class="underline decoration-2 text-[#adc1a4] hover:opacity-80">info@veresk-landshaft.ru</a>
                </div>
            </div>
            <div>
                <div class="font-helvetica text-4xl sm:text-[40px] mb-2.5">Телефон</div>
                <div class="sm:text-xl">
                    <a href="tel:+78129051863" class="underline decoration-2 text-[#adc1a4] hover:opacity-80">+7 (812) 905-18-63</a>,
                    <a href="tel:+79219051863" class="underline decoration-2 text-[#adc1a4] hover:opacity-80">+7 (921) 905-18-63</a>
                </div>
            </div>
        </div>
    </div>

    <div class="my-28">
        <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ae093e44cfe769784543e40b36e4f5f00429bfaab842c81cc8175dd9d1bf77862&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=false"></script>
    </div>
@endsection
