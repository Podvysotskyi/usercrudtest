<template>
    <Link :href="href" :disabled="disabled" v-if="href"
        :class="['inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition ease-in-out duration-150', disabled ? 'opacity-25' : 'cursor-pointer']">
    <slot />
    </Link>
    <button :type="type" :disabled="disabled" v-else
        :class="['inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none transition ease-in-out duration-150', disabled ? 'opacity-25' : 'cursor-pointer']">
        <slot />
    </button>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    props: {
        href: {
            type: String,
            default: null,
        },
        type: {
            type: String,
            default: 'submit',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    components: {
        Link,
    },
}
</script>