<template>
    <div
        v-if="!to"
        :class="getButtonClass"
        tabindex="0"
        @click="handleClick"
    >
        <div :class="{hidden: loading}"><slot /></div>
        <div v-show="loading" class="spinner-border text-white v-button__spinner" role="status" />
    </div>
    <router-link
        v-else
        :to="to"
        :class="getButtonClass"
        tabindex="0"
        @click="event => $emit('click', event)"
    >
        <div :class="{hidden: loading}"><slot /></div>
        <div v-show="loading" class="spinner-border v-button__spinner" role="status" />
    </router-link>
</template>

<script>
// const BUTTON_COLORS = ['transparent', 'primary', 'secondary', 'danger']

export default {
    name: "VButton",
    props: {
        loading: {
            type: Boolean,
            default() {
                return false;
            },
            required: false,
        },
        disabled: {
            type: Boolean,
            default() {
                return false;
            },
            required: false,
        },
        color: {
            type: String,
            default() {
                return 'transparent'
            },
            // validator(value) {
            //     return BUTTON_COLORS.includes(value)
            // },
        },
        to: {
            required: false,
            type: String,
        },
        emits: ['click'],
    },
    computed: {
        getButtonClass() {
            const classes = [
                'btn',
                'position-relative',
                'btn-' + this.color,
            ];

            if (this.disabled || this.loading) {
                classes.push('disabled')
            }

            return classes.join(' ');
        }
    },
    methods: {
        handleClick(event) {
            if (this.loading || this.disabled) {
                return;
            }

            this.$emit('click', event);
        }
    },
}
</script>

<style scoped>
.v-button__spinner {
    position: absolute;
    margin: auto;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;

    width: 20px;
    height: 20px;
    border-width: 2px;
    color: inherit !important;
}

.hidden {
    visibility: hidden;
}
</style>
