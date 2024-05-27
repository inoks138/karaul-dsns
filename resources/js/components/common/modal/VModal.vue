<template>
    <div class="modal" :class="{show}">
        <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
            <slot/>
        </div>
        <div class="modal-backdrop"></div>
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
}
</script>

<style lang="scss" scoped>
.modal.show {
    display: block;
}
.modal {
    .modal-backdrop {
        opacity: 0.3;
    }

    .modal-dialog {
        z-index: 1051;
    }
}
</style>
