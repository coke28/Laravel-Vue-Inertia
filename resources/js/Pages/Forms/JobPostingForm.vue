<template>
    <Head title="Create a Job Posting" />

    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ headerTitle }}
            </h2>
        </div>
    </header>
    <Card>
        <div>
            <form @submit.prevent="handleSubmit">
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <input
                            v-if="editMode"
                            type="hidden"
                            name="id"
                            v-model="fields.id"
                        />
                        <InputLabel value="Job Name"></InputLabel>
                        <TextInput
                            placeholder="Please Enter Job Name"
                            v-model="fields.job_name"
                            autofocus
                        ></TextInput>
                        <InputError
                            class="mt-1"
                            v-if="errors.job_name"
                            :message="errors.job_name"
                        ></InputError>
                    </div>
                    <div class="sm:col-span-2">
                        <InputLabel value="Job Description"></InputLabel>
                        <TextAreaInput
                            placeholder="Please Enter Job Description"
                            v-model="fields.job_description"
                        ></TextAreaInput>
                        <InputError
                            class="mt-1"
                            v-if="errors.job_description"
                            :message="errors.job_description"
                        ></InputError>
                    </div>
                    <div class="sm:col-span-2">
                        <InputLabel value="Active"></InputLabel>
                        <SelectInput
                            v-model="fields.status"
                            required
                        ></SelectInput>
                        <InputError
                            class="mt-1"
                            v-if="errors.status"
                            :message="errors.status"
                        ></InputError>
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex justify-end gap-1 pt-4">
                    <PrimaryButton type="submit">Submit</PrimaryButton>

                    <SecondaryButton>
                        <Link href="/">Go Back</Link>
                    </SecondaryButton>
                </div>
            </form>
        </div>
    </Card>
</template>
<script>
import Card from "@/Components/Card.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import TextInput from "@/Components/TextInput.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

export default {
    components: {
        Head,
        Link,
        Card,
        PrimaryButton,
        SecondaryButton,
        InputLabel,
        TextInput,
        TextAreaInput,
        InputError,
        SelectInput,
    },
    layout: AuthenticatedLayout,
    data() {
        return {
            fields: {},
        };
    },
    props: {
        headerTitle: {
            type: String,
        },
        editMode: {
            type: Boolean,
            default: false,
        },
        jobPosting: {
            type: Object,
        },
        submitRoute: {
            type: String,
        },
        errors: {
            type: Object,
        },
    },
    methods: {
        handlePrimaryClick(event) {
            // Your normal click logic here
            console.log("Primary button clicked", event);
        },
        handleSubmit() {
            // Your normal click logic here
            router.post(this.submitRoute, this.fields);
        },
    },
    mounted() {
        if (this.editMode && this.jobPosting) {
            this.fields = this.jobPosting;
        }
    },
};
</script>
