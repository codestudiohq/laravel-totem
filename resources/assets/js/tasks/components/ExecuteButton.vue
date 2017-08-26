<template>
    <transition mode="out-in">
        <button type="button" class="uk-button uk-button-small" :class="{ 'uk-button-primary': !running, 'uk-spinner uk-icon uk-button-secondary': running}" @click="execute" :disabled="running">
            <span v-if="!running">Execute</span>
            <icon v-if="running" name="spinner" :scale="100"></icon>
        </button>
    </transition>
</template>

<script>
    import Icon from '../../components/Icon.vue'
    export default {
        components: {
            'icon':Icon
        },
        props: [
            'dataTask'
        ],
        data() {
            return {
                running: false,
                task: this.dataTask
            }
        },
        methods: {
            execute() {
                this.running = true

                axios.get('/totem/tasks/' + this.task.id + '/execute')
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