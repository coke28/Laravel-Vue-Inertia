<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Datatable from "../Components/Datatable/Datatable.vue";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Datatable,
    },
    props: {
        data: {
            type: Object,
            required: true,
        },
        dataModel: {
            type: String,
            default: "Default data model",
        },
        tableColumns: {
            type: Array,
            required: true,
        },
        tools: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
            required: true,
        },
    },
};
</script>

<template>
    <Head title="Job Postings" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Job Posting
            </h2>
        </template>
        <Datatable
            :data="data"
            :dataModel="dataModel"
            :tableColumns="tableColumns"
            :tools="tools"
            :filters="filters"
        ></Datatable>
    </AuthenticatedLayout>
</template>
