<template>
    <transition mode="out-in">
        <button v-if="task.activated" type="button" class="uk-button uk-button-small" :class="{ 'uk-button-primary': !hovering && !working, 'uk-button-danger': hovering && !working, 'uk-button-secondary': working}" key="enabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="deactivate" :disabled="working">
            {{ activeStatusText }}
        </button>
        <button v-if="existsAndIsInActive" type="button" class="uk-button uk-button-small" :class="{'uk-button-danger': !hovering && !working, 'uk-button-primary': hovering && !working, 'uk-button-secondary': working}" key="disabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="activate" :disabled="working">
            {{ inActiveStatusText }}
        </button>
    </transition>
</template>

<script>
export default {
    props: [
        'dataTask',
        'dataExists'
    ],
    data() {
        return {
            hovering: false,
            working: false,
            task: this.dataTask,
            exists: this.dataExists,
        }
    },
    computed: {
        inActiveStatusText() {
            return this.hovering ? 'Enable' : 'Disabled'
        },
        activeStatusText(){
            return this.hovering ? 'Disable' : 'Enabled'
        },
        existsAndIsInActive() {
            return !this.task.activated && this.exists;
        }
    },
    methods: {
        activate() {
            this.working = true

            axios.post('/totem/tasks/status', { task_id: this.task.id })
                .takeAtLeast(300)
                .then(response => {
                    this.task = response.data
                    this.working = false
                    this.hovering = false
                })
        },
        deactivate() {
            this.working = true

            axios.delete(`/totem/tasks/status/${this.task.id}`)
                .takeAtLeast(300)
                .then(response => {
                    this.task = response.data
                    this.working = false
                    this.hovering = false
                })
        },
    },
    mounted() {
    }
}
</script>
