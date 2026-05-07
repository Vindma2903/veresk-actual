<script>
    export let services = [];
    export let title = 'Что мы делаем';
    export let image = 'https://placehold.co/630x690';
</script>

<div class="border-y border-gray-500">
    <div class="container">
        <div class="md:flex justify-center">
            <div class="md:border-l border-gray-500 md:flex md:flex-col">
                <div class="py-5 border-gray-500 border-b">
                    <h3 class="text-2xl md:px-4">{title}</h3>
                </div>

                <div class="md:flex-1 md:flex md:items-center">
                    <img src="{image}" class="md:p-5 lg:p-8 max-h-[690px]" alt="">
                </div>
            </div>
            <div class="md:border-x md:border-gray-500 md:max-h-[600px] lg:max-h-[780px] md:overflow-y-scroll">
                {#each services as s}
                    <a href="/services/{s.slug}" class="block w-full border-t first:border-t-0 border-gray-500 text-left py-5 md:px-4 hover:bg-gray-900">
                        {s.title}
                    </a>
                {/each}
            </div>
        </div>
    </div>
</div>

