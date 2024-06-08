<template>
    <div class="modal" :class="{show}">
        <div class="modal-dialog modal-dialog-centered justify-content-center modal-lg" role="document">
            <slot/>
        </div>
        <div class="modal-backdrop" @click="closeModal"></div>
    </div>
</template>

<script>

export default {
    name: "VModal",
    props: {
        show: {
            type: Boolean,
            required: true,
        },
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
    },
}
</script>

<style lang="scss" scoped>
.modal.show {
    display: block;
}
.modal {
    .modal-backdrop {
        opacity: 0.5;
    }

    .modal-dialog {
        z-index: 1051;
    }
}
</style>
