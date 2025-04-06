<template>
    <form @submit.prevent class="w-[600px] h-[80px] flex items-center">
        <TextInput
            type="text"
            class="block w-full mr-2"
            v-model="search"
            autocomplete
            @keyup.enter="onSearch"
            placeholder="Search for files and folders"
        />
    </form>
</template>

<script setup>
import TextInput from "@/Components/TextInput.vue";
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";

let params = "";

const search = ref("");

function onSearch() {
    params.set("search", search.value);
    router.get(window.location.pathname + "?" + params.toString());
}

onMounted(() => {
    params = new URLSearchParams(window.location.search);
    search.value = params.get("search");
});
</script>
