<template>
    <Head title="Trash" />

    <AuthenticatedLayout>
        <nav class="flex items-center justify-end p-1 mb-3">
            <div class="flex items-center gap-x-3">
                <RestoreFilesButton
                    :allSelected="allSelected"
                    :selectedIds="selectedIds"
                    @restore="resetForm"
                />
                <DeleteForeverButton
                    :allSelected="allSelected"
                    :selectedIds="selectedIds"
                    @delete="resetForm"
                />
            </div>
        </nav>
        <div class="flex-1 overflow-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th
                            class="text-sm font-medium text-gray-900 px-6 py-4 text-left w-[30px] max-w-[30px] pr-0"
                        >
                            <Checkbox
                                @change="onSelectAllChange"
                                v-model:checked="allSelected"
                            />
                        </th>
                        <th
                            class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                        >
                            Имя
                        </th>
                        <th
                            class="text-sm font-medium text-gray-900 px-6 py-4 text-left"
                        >
                            Путь
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="file of allFiles.data"
                        :key="file.id"
                        @click="($event) => toggleFileSelect(file)"
                        class="border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer"
                        :class="
                            selected[file.id] || allSelected
                                ? 'bg-blue-50'
                                : 'bg-white'
                        "
                    >
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 w-[30px] max-w-[30px] pr-0"
                        >
                            <Checkbox
                                @change="
                                    ($event) => onSelectCheckboxChange(file)
                                "
                                v-model="selected[file.id]"
                                :checked="selected[file.id] || allSelected"
                            />
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center"
                        >
                            <FileIcon :file="file" />
                            {{ file.name }}
                        </td>
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                        >
                            {{ file.path }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div
                v-if="!allFiles.data.length"
                class="py-8 text-center text-md text-gray-400"
            >
                В этой папке нет данных
            </div>
            <div ref="loadMoreIntersect"></div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FileIcon from "@/Components/app/FileIcon.vue";
import RestoreFilesButton from "@/Components/app/RestoreFilesButton.vue";
import DeleteForeverButton from "@/Components/app/DeleteForeverButton.vue";
import Checkbox from "@/Components/Checkbox.vue";
import { Head } from "@inertiajs/vue3";
import { computed, onMounted, onUpdated, ref } from "vue";
import { httpGet } from "@/Helper/http-helper";

const allSelected = ref(false);
const selected = ref({});
const loadMoreIntersect = ref(null);

const props = defineProps({
    files: Object,
    folder: Object,
    ancestors: Object,
});

const allFiles = ref({
    data: props.files.data,
    next: props.files.links.next,
});

const selectedIds = computed(() =>
    Object.entries(selected.value)
        .filter((el) => el[1])
        .map((el) => el[0])
);

function loadMore() {
    if (allFiles.value.next === null) {
        return;
    }

    httpGet(allFiles.value.next).then((res) => {
        allFiles.value.data = [...allFiles.value.data, ...res.data];
        allFiles.value.next = res.links.next;
    });
}

function onSelectAllChange() {
    allFiles.value.data.forEach((f) => {
        selected.value[f.id] = allSelected.value;
    });
}

function onSelectCheckboxChange(file) {
    if (!selected.value[file.id]) {
        allSelected.value = false;
    } else {
        let checked = true;

        for (let file of allFiles.value.data) {
            if (!selected.value[file.id]) {
                checked = false;
                break;
            }
        }

        allSelected.value = checked;
    }
}

function toggleFileSelect(file) {
    selected.value[file.id] = !selected.value[file.id];
    onSelectCheckboxChange(file);
}

function resetForm() {
    allSelected.value = false;
    selected.value = {};
}

onUpdated(() => {
    allFiles.value = {
        data: props.files.data,
        next: props.files.links.next,
    };
});

onMounted(() => {
    allFiles.value = {
        data: props.files.data,
        next: props.files.links.next,
    };

    const observer = new IntersectionObserver(
        (entries) =>
            entries.forEach((entry) => entry.isIntersecting && loadMore()),
        {
            rootMargin: "-250px 0px 0px 0px",
        }
    );

    observer.observe(loadMoreIntersect.value);
});
</script>
