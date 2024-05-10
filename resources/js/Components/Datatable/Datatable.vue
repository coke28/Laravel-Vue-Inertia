<template>
    <div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div
                            class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 pt-4 p-4">
                            <PrimaryButton v-if="tools.addRoute">
                                <Link href="/">Add Job Posting</Link>
                            </PrimaryButton>

                            <DatatableSearch
                                @update:modelValue="searchTable"
                                :modelValue="search"
                            >
                            </DatatableSearch>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th
                                        v-for="column in tableColumns"
                                        :key="column.header_value"
                                        scope="col"
                                        class="px-6 py-3"
                                    >
                                        <div class="flex items-center">
                                            {{ column.header_name }}
                                            <div
                                                v-if="column.orderable"
                                                @click="
                                                    sortColumn(
                                                        column.header_value
                                                    )
                                                    "
                                            >
                                                <svg
                                                    class="w-3 h-3 ms-1.5"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </th>

                                    <th
                                        v-if="tools"
                                        scope="col"
                                        class="px-6 py-3"
                                    >
                                        Tools
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="data_row in data.data"
                                    :key="data_row.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                >
                                    <th
                                        v-for="column in tableColumns"
                                        :key="column.header_value"
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ data_row[column.header_value] }}
                                    </th>
                                    <td
                                        v-if="tools"
                                        class="px-6 py-4"
                                    >
                                        <a
                                            v-if="tools.editRoute"
                                            href="#"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        >Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <DatatablePagination
                            @update:modelValue="paginateTable"
                            :modelValue="filters.pagination"
                            :links="data.meta.links"
                            :totalPage="data.meta.total"
                        >
                        </DatatablePagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link, router } from "@inertiajs/vue3";
import DatatablePagination from "../Datatable/DatatablePaginator.vue";
import DatatableSearch from "../Datatable/DatatableSearch.vue";
import PrimaryButton from "../PrimaryButton.vue";

export default {
    components: {
        DatatablePagination,
        DatatableSearch,
        Link,
        PrimaryButton,
    },
    data() {
        return {
            columnToBeSorted: this.filters.columnToBeSorted,
            order: this.filters.order,
            search: this.filters.search,
            pagination: this.filters.pagination,
            page: this.filters.page,
        };
    },
    props: {
        data: {
            type: Object,
            required: true,
        },
        indexRoute: {
            type: String,
            required: true,
        },
        tableColumns: {
            type: Array,
            required: true,
        },
        tools: {
            type: Array,
            required: false,
        },
        filters: {
            type: Object,
            required: true,
        },
    },
    methods: {
        getData() {
            router.get(
                this.indexRoute,
                {
                    columnToBeSorted: this.columnToBeSorted,
                    order: this.order,
                    pagination: this.pagination,
                    page: this.page,
                    search: this.search,
                },
                { preserveState: true }
            );
        },
        sortColumn(selectedColumn) {
            if (this.columnToBeSorted === selectedColumn) {
                this.order = this.order === "asc" ? "desc" : "asc";
            } else {
                this.columnToBeSorted = selectedColumn;
                this.order = "asc";
            }
            this.getData();
        },
        paginateTable(input) {
            this.pagination = input;
            this.page = 1;
            this.getData();
        },
        searchTable(input) {
            this.page = 1;
            this.search = input;
            this.getData();
        },
    },
};
</script>
