<template>
    <MenuItem v-slot="{ active }">
        <a href="#" class="text-gray-700 block px-4 py-2 text-sm relative">
            Загрузить папку
            <input
                @change="onChange"
                type="file"
                multiple
                directory
                webkitdirectory
                class="absolute left-0 top-0 bottom-0 right-0 cursor-pointer opacity-0"
            />
        </a>
    </MenuItem>
</template>

<script setup>
import { MenuItem } from "@headlessui/vue";
import { emitter, FILE_UPLOAD_STARTED } from "@/event-bus";

function onChange(ev) {
    emitter.emit(FILE_UPLOAD_STARTED, ev.target.files);
}
</script>

<style scoped></style>
