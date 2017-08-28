<template>
    <transition mode="out-in">
        <button type="button" class="uk-button" :class="buttonClasses" @click="execute" :disabled="running">
            <icon v-if="iconName && !running" :name="iconName" :scale="100"></icon>
            <span v-else>
                <span v-if="!running">Execute</span>
            </span>
            <icon v-if="running" name="spinner" :spin="true" :scale="80"></icon>
        </button>
    </transition>
</template>

<script>
    import Icon from '../../components/Icon.vue'
    export default {
        components: {
            'icon':Icon
        },
        props: {
            dataTask: {},
            url: {
                type: String,
                required: true
            },
            iconName: {
                type: String,
                default: null
            },
            buttonClass: {
                type: String,
                default: 'uk-button-small'
            }
        },
        data() {
            return {
                running: false,
                task: this.dataTask
            }
        },
        computed: {
          buttonClasses() {
              return this.running ? 'uk-spinner uk-icon' : this.buttonClass;
          }
        },
        methods: {
            execute() {
                this.running = true

                axios.get(this.url)
                    .takeAtLeast(500)
                    .then(response => {
                        this.task = response.data
                        this.running = false
                    })
            }
        },
        mounted() {
        }
    }
</script>