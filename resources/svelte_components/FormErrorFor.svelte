<script>
    export let errors = {};
    export let key = '';
</script>
{#if (typeof errors === 'object' && errors.hasOwnProperty(key) && Array.isArray(errors[key]))}
    <div class="text-sm text-red-400">
        {errors[key].join(' ')}
    </div>
{/if}
