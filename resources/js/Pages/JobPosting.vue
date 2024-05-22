<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import Datatable from "../Components/Datatable/Datatable.vue";

export default {
  components: {
    Head,
    Datatable,
  },
  layout: AuthenticatedLayout,
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

  <header class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Job Posting
      </h2>
    </div>
  </header>

  <Datatable
    :data="data"
    :dataModel="dataModel"
    :tableColumns="tableColumns"
    :tools="tools"
    :filters="filters"
  ></Datatable>
</template>

<!-- <template>
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
</template> -->
