<!-- eslint-disable vue/no-reserved-component-names -->
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import Datatable from '../Components/Datatable/Datatable.vue'

export default {
  components: {
    AuthenticatedLayout,
    Head,
    Datatable
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
    tableColumns: {
      type: Array,
      required: true,
    },
    tools: {
      type: Array,
      required: true,
    },
    filters: {
      type: Object,
      required: true,
    }
  },
}
</script>

<template>

  <Head title="Categories" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Category</h2>
    </template>
    <Datatable :data="data" :tableColumns="tableColumns" :tools="tools" :filters="filters"></Datatable>
  </AuthenticatedLayout>
</template>
