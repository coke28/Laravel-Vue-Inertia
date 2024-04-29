<!-- eslint-disable vue/no-v-text-v-html-on-component -->
<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4 mx-4 my-4"
        aria-label="Table navigation">
        <span
            class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
            Showing
            <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value)"
                class="inline-flex w-12 p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option :value="5">5</option>
                <option :value="10">10</option>
                <option :value="25">25</option>
                <option :value="50">50</option>
            </select>
            of {{ totalPage }}
        </span>
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <li v-for="link in links" :key="link.label">
                <template v-if="link.url && !link.active">
                    <Link :href="link.url" v-html="link.label"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    </Link>
                </template>
                <template v-else>
                    <span :href="link.url" v-html="link.label"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
                    </span>
                </template>
            </li>
        </ul>
    </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'
export default {
    components: {
        // eslint-disable-next-line vue/no-reserved-component-names
        Link,
    },
    props: {
        links: {
            type: Object,
            required: true
        },
        totalPage: {
            type: Number,
            required: true
        },
        modelValue: {
            type: String,
            required: true
        }

    },
    emits: ['update:modelValue']

}
</script>