<script>
export default {
    props: {
        modelValue: {
            type: String,
        },
        placeholder: {
            type: String,
            default: "Default Placeholder text",
        },
        rows: {
            type: Number,
            default: 4,
        },
    },
    emits: ["update:modelValue"],
};
</script>
<template>
    <textarea
        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        :placeholder="placeholder"
        :rows="rows"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    ></textarea>
</template>
