<script>
export default {
    props: {
        modelValue: {
            type: String,
        },
        options: {
            default: [
                {
                    name: "Active",
                    value: 1,
                },
                {
                    name: "Disabled",
                    value: 0,
                },
            ],
        },
    },
    emits: ["update:modelValue"],
};
</script>

<template>
    <div>
        <select
            class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
            @input="$emit('update:modelValue', $event.target.value)"
            :value="modelValue"
        >
            <option disabled value="">Please select an option</option>
            <option
                v-for="(option, index) in options"
                :key="index"
                :value="option.value"
            >
                {{ option.name }}
            </option>
        </select>
    </div>
</template>
