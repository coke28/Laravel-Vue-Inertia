<!-- eslint-disable no-unused-vars -->
<script setup>
import ToastListItem from "@/Components/Toast/ToastListItem.vue";
import { onUnmounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import toast from "@/Stores/toast";

const page = usePage();

let removeFinshEventListener = router.on("finish", () => {
    if (page.props.toast.message) {
        toast.add({
            message: page.props.toast.message,
            type: page.props.toast.type,
        });
    }
});

onUnmounted(() => removeFinshEventListener());

function remove(index) {
    toast.remove(index);
}
</script>
<template>
    <TransitionGroup
        tag="div"
        enter-from-class="translate-x-full opacity-0"
        enter-active-class="duration-500"
        leave-active-class="duration-500"
        leave-to-class="translate-x-full opacity-0"
        class="fixed top-4 right-4 z-50 w-full max-w-xs space-y-4"
    >
        <ToastListItem
            v-for="(item, index) in toast.items"
            :key="item.key"
            :message="item.message"
            :type="item.type"
            :duration="2000"
            @remove="remove(index)"
        />
    </TransitionGroup>
</template>
