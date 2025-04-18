<template>
    <div class="min-h-screen bg-gray-100 flex w-full gap-4">
        <Navigation />

        <main
            @drop.prevent="handleDrop"
            @dragover.prevent="onDragOver"
            @dragleave.prevent="onDragLeave"
            class="flex flex-col flex-1 px-4"
            :class="dragOver ? 'dropzone' : ''"
        >
            <template
                v-if="dragOver"
                class="text-gray-500 text-center py-8 text-sm"
            >
                Сбрасывайте файлы сюда для загрузки
            </template>
            <template v-else>
                <div
                    class="flex items-center justify-center md:justify-between w-full"
                >
                    <SearchForm />
                    <UserSettingsDropdown />
                </div>
                <div class="flex-1 flex flex-col">
                    <slot />
                </div>
            </template>
        </main>
    </div>

    <ErrorDialog />
    <FormProgress :form="fileUploadForm" />
    <Notification />
</template>

<script setup>
import Navigation from "@/Components/app/Navigation.vue";
import SearchForm from "@/Components/app/SearchForm.vue";
import UserSettingsDropdown from "@/Components/app/UserSettingsDropdown.vue";
import FormProgress from "@/Components/app/FormProgress.vue";
import ErrorDialog from "@/Components/ErrorDialog.vue";
import Notification from "@/Components/Notification.vue";
import { ref, onMounted } from "vue";
import {
    emitter,
    FILE_UPLOAD_STARTED,
    showErrorDialog,
    showSuccessNotification,
} from "@/event-bus";
import { useForm, usePage } from "@inertiajs/vue3";

const page = usePage();
const fileUploadForm = useForm({
    files: [],
    relative_paths: [],
    parent_id: null,
});

const dragOver = ref(false);

function onDragOver() {
    dragOver.value = true;
}

function onDragLeave() {
    dragOver.value = false;
}

function uploadFiles(files) {
    fileUploadForm.parent_id = page.props.folder.id;
    fileUploadForm.files = files;
    fileUploadForm.relative_paths = [...files].map((f) => f.webkitRelativePath);

    fileUploadForm.post(route("file.store"), {
        onSuccess: () => {
            showSuccessNotification(`${files.length} файлов было обновлено`);
        },
        onError: (errors) => {
            let message = "";

            if (Object.keys(errors).length > 0) {
                message = errors[Object.keys(errors)[0]];
            } else {
                message =
                    "Ошибка при обновлении. Пожалуйста, попробуйте позже.";
            }

            showErrorDialog(message);
        },
        onFinish: () => {
            fileUploadForm.clearErrors();
            fileUploadForm.reset();
        },
    });
}

function handleDrop(ev) {
    dragOver.value = false;
    const files = ev.dataTransfer.files;
    console.log(files);
    if (!files.length) return;

    uploadFiles(files);
}

onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles);
});
</script>

<style scoped>
.dropzone {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 50%;
    color: #8d8d8d;
    border: 2px dashed gray;
}
</style>
