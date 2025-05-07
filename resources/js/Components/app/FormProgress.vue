<template>
    <div
        v-if="form.progress"
        class="absolute border-gray-900 border right-8 bottom-4 bg-white shadow-lg rounded flex flex-col w-[240px] p-3"
    >
        <div class="text-xs mb-2">Загзрузка {{ form.files.length }} файлов</div>
        <div class="h-3 bg-gray-100 rounded-md">
            <div
                class="h-full bg-gray-900 rounded-md transition-all"
                :style="{ width: form.progress.percentage + '%' }"
            ></div>
        </div>
    </div>
</template>

<script setup>
const { form } = defineProps({
    form: Object,
});
</script>

<style scoped></style>
