<template>
    <Head title="Create a Job Posting" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create a Job Posting
            </h2>
        </template>
        <Card>
            <div>
                <form @submit.prevent="handleSubmit">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <InputLabel value="Job Name"></InputLabel>
                            <TextInput
                                v-model="fields.job_name"
                                autofocus
                                required
                            ></TextInput>
                            <InputError></InputError>
                        </div>
                        <div class="sm:col-span-2">
                            <InputLabel value="Job Description"></InputLabel>
                            <TextAreaInput
                                v-model="fields.job_description"
                            ></TextAreaInput>
                            <InputError></InputError>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-1 pt-4">
                        <PrimaryButton type="submit">Submit</PrimaryButton>

                        <SecondaryButton>
                            <Link href="/">Secondary</Link>
                        </SecondaryButton>
                    </div>
                </form>
            </div>
        </Card>
    </AuthenticatedLayout>
</template>
<script>
import Card from "@/Components/Card.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Link,
        Card,
        PrimaryButton,
        SecondaryButton,
        InputLabel,
        TextInput,
        TextAreaInput,
        InputError,
    },
    data() {
        return {
            fields: {},
            errors: {},
        };
    },
    props: {},
    methods: {
        handlePrimaryClick(event) {
            // Your normal click logic here
            console.log("Primary button clicked", event);
        },
        handleSubmit(event) {
            // Your normal click logic here
            console.log("Submit button clicked", event);
        },
    },
    mounted() {},
};
</script>
