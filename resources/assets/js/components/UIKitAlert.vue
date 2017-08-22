<template>
    <div :class="classes" v-if="show">
        <a class="uk-alert-close uk-close uk-icon" @click="show = false">
            <icon name="close" :scale="100"></icon>
        </a>
        <slot></slot>
    </div>
</template>

<script>
    import Icon from './Icon.vue'
    export default {
        name: 'UIKitAlert',
        components: {
            'icon'  : Icon
        },
        props: {
            type: {
                type: String,
                default: 'primary'
            },
            important: {
                type: Boolean,
                default: false
            },
            timeout: { default: 5000 }
        },
        data() {
            return { show: true };
        },
        computed: {
            classes: function () {
                return 'uk-alert uk-alert-' + this.type
            }
        },
        mounted() {
            if (! this.important) {
                setTimeout(
                    () => this.show = false,
                    this.timeout
                )
            }
        }
    }
</script>
