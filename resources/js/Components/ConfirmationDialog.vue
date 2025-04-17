<template>
    <Modal :show="show" max-width="md">
        <div class="p-6">
            <h2 class="text-2xl mb-2 font-semibold">Пожалуйста, подтвердите</h2>
            <p>{{ message }}</p>

            <div class="mt-6 flex justify-end gap-x-2">
                <SecondaryButton @click="($event) => emit('cancel')">
                    Отменить
                </SecondaryButton>

                <DangerButton @click="($event) => emit('confirm')">
                    Подтвердить
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    show: Boolean,
    message: String,
});

const emit = defineEmits(["cancel", "confirm"]);
</script>

<style scoped></style>
