<template>
    <modal :show="modelValue" @show="onShow" max-width="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Создать новую папку</h2>
            <div class="mt-6">
                <InputLabel
                    for="folderName"
                    value="Название папки"
                    class="sr-only"
                />
                <TextInput
                    type="text"
                    ref="folderNameInput"
                    id="folderName"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    :class="
                        form.errors.name
                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                            : ''
                    "
                    placeholder="Название"
                    @keyup.enter="createFolder"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Отмена</SecondaryButton>
                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    @click="createFolder"
                    :disabled="form.processing"
                    >Подтвердить</PrimaryButton
                >
            </div>
        </div>
    </modal>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";
import { showSuccessNotification } from "@/event-bus";

const form = useForm({
    name: "",
    parent_id: null,
});
const page = usePage();

const folderNameInput = ref(null);

const { modelValue } = defineProps({
    modelValue: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

function onShow() {
    nextTick(() => folderNameInput.value.focus());
}

function createFolder() {
    form.parent_id = page.props.folder.id;
    const name = form.name;
    form.post(route("folder.create"), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showSuccessNotification(`Папка "${name}" создана`);
            form.reset();
        },
        onError: () => folderNameInput.value.focus(),
    });
}

function closeModal() {
    emit("update:modelValue");
    form.clearErrors();
    form.reset();
}
</script>
