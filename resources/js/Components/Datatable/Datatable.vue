<template>
  <div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div
          class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
              class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 pt-4 p-4"
            >
              <PrimaryButton v-if="tools.addRoute">
                <Link :href="tools.addRoute">Add {{ dataModel }}</Link>
              </PrimaryButton>

              <DatatableSearch v-model.trim="search"> </DatatableSearch>
            </div>
            <table
              class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
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
                        @click="sortColumn(column.header_value)"
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
                    <Dropdown
                      align="right"
                      width="48"
                    >
                      <template #trigger>
                        <span class="inline-flex rounded-md">
                          <PrimaryButton type="button">
                            Tools
                            <svg
                              class="ms-2 -me-0.5 h-4 w-4"
                              xmlns="http://www.w3.org/2000/svg"
                              viewBox="0 0 20 20"
                              fill="currentColor"
                            >
                              <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                              />
                            </svg>
                          </PrimaryButton>
                        </span>
                      </template>

                      <template #content>
                        <DropdownLink
                          v-if="tools.editRoute"
                          :href="route(tools.editRoute, data_row.id)"
                        >
                          Edit
                        </DropdownLink>

                        <DropdownLink
                          v-if="tools.deleteRoute"
                          href="#"
                          method="post"
                          as="button"
                          @click="deleteModel(data_row.id)"
                        >
                          Delete
                        </DropdownLink>
                      </template>
                    </Dropdown>
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
import Dropdown from "../Dropdown.vue";
import DropdownLink from "../DropdownLink.vue";
import debounce from "lodash/debounce";

export default {
  components: {
    DatatablePagination,
    DatatableSearch,
    Link,
    PrimaryButton,
    Dropdown,
    DropdownLink,
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
  methods: {
    getData() {
      router.get(
        this.tools.indexRoute,
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

    searchTable: debounce(function (input) {
      this.page = 1;
      this.search = input;
      this.getData();
    }, 200),

    deleteModel(input) {
      router.delete(route(this.tools.deleteRoute, input));
    },
  },
  watch: {
    search(newValue) {
      this.searchTable(newValue);
    },
  },
};
</script>
