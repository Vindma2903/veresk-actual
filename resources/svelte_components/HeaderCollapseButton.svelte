<script>
    export let menu_items = [];
    export let menu_contacts = [];
    let isActive = false;


    function handleClick()
    {
        isActive = !isActive;
        if (isActive) {
            document.body.classList.add('overflow-hidden', 'lg:overflow-visible');
        } else {
            document.body.classList.remove('overflow-hidden', 'lg:overflow-visible');
        }
    }

    function hasChild(item) {
        return Object.hasOwn(item, 'children');
    }
</script>

<button type="button" class="lg:hidden w-[40px] h-[70px]" on:click={handleClick}>
    {#if isActive}
        <div class="w-[40px] bg-white opacity-70 h-px rotate-45"></div>
        <div class="w-[40px] bg-white opacity-70 h-px -rotate-45"></div>
    {:else}
        <div class="flex flex-col gap-2.5">
            <div class="w-[40px] bg-white opacity-70 h-px"></div>
            <div class="w-[40px] bg-white opacity-70 h-px"></div>
            <div class="w-[40px] bg-white opacity-70 h-px"></div>
        </div>
    {/if}
</button>

{#if isActive}
    <div class="lg:hidden fixed left-0 right-0 bottom-0 top-[78px] bg-black overflow-y-scroll">
        <div class="text-base mb-5">
            {#each menu_items as item}
                <a href="{ item.url }" class="block p-4 {!hasChild(item) ? 'border-b border-gray-500' : ''}">
                    <i class="las la-angle-right opacity-40 mr-2.5"></i>
                    <span class="text-lg">{ item.title }</span>
                </a>
                {#if Object.hasOwn(item, 'children')}
                    <div class="ml-5">
                        {#each item['children'] as child}
                            <a href="{ child.url }" class="block p-2">
                                <i class="las la-circle opacity-40 mr-2.5"></i>
                                <span class="">{ child.title }</span>
                            </a>
                        {/each}
                    </div>
                    <div class="border-t border-gray-500 mt-4"></div>
                {/if}
            {/each}
        </div>

        <div class="text-center text-lg flex flex-col gap-2.5 mb-5">
            {#each menu_contacts as c}
                <a href="{c.url}" class="underline" target="_blank">
                    <i class="{c.i} mr-1 la-lg opacity-40"></i> {c.title}
                </a>
            {/each}
        </div>
    </div>
{/if}
