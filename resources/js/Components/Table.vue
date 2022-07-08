<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead :class="headClass">
            <tr>
                <slot />
            </tr>
        </thead>
        <tbody :class="bodyClass">
            <tr v-if="data.length === 0">
                <td colspan="1000">
                    Nothing found
                </td>
            </tr>
            <template v-else>
                <tr v-for="row in data" :key="row.id">
                    <slot name="row" :row="row" />
                </tr>
            </template>
            <tr v-if="meta || links">
                <td colspan="1000" class="border-t border-gray-200">
                    <nav class="bg-white px-4 py-3 flex items-center justify-between" aria-label="Pagination">
                        <div class="hidden sm:block">
                            <p class="text-sm text-gray-700" v-if="meta">
                                Showing
                                {{ ' ' }}
                                <span class="font-medium">
                                    {{ meta.from }}
                                </span>
                                {{ ' ' }} to {{ ' ' }}
                                <span class="font-medium">
                                    {{ meta.to }}
                                </span>
                                {{ ' ' }} of {{ ' ' }}
                                <span class="font-medium">
                                    {{ meta.total }}
                                </span>
                                {{ ' ' }}
                                results
                            </p>
                        </div>
                        <div class="flex-1 flex justify-between sm:justify-end">
                            <Link :href="links.prev" as="button" :disabled="!links.prev" v-if="links"
                                :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-gray-700', links.prev ? 'bg-white border-gray-300 hover:bg-gray-50 cursor-pointer' : 'bg-gray-50 border-gray-200']">
                            Previous
                            </Link>
                            <Link :href="links.next" as="button" :disabled="!links.next" v-if="links"
                                :class="['ml-3 relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-md text-gray-700', links.next ? 'bg-white border-gray-300 hover:bg-gray-50 cursor-pointer' : 'bg-gray-50 border-gray-200']">
                            Next
                            </Link>
                        </div>
                    </nav>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

import Button from '@/Components/Button.vue';

export default {
    props: {
        data: {
            type: Array,
            default: [],
        },
        meta: {
            type: Object,
            default: null,
        },
        links: {
            type: Object,
            default: null,
        },
        headClass: {
            type: String,
            default: 'bg-gray-50',
        },
        bodyClass: {
            type: String,
            default: 'divide-y divide-gray-200',
        },
    },
    components: {
        Link,
        Button,
    },
}
</script>
