<template>
    <transition mode="out-in">
        <button v-if="task.activated" type="button" class="btn btn-md" :class="{'btn-secondary': !hovering && !working, 'btn-primary': hovering && !working, 'btn-loading btn-primary': working}" key="enabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="deactivate" :disabled="working">
            {{ inActiveStatusText }}
        </button>
        <button v-if="existsAndIsInActive" type="button" class="btn btn-md" :class="{'btn-primary': !hovering && !working, 'btn-secondary': hovering && !working, 'btn-loading btn-primary': working}" key="disabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="activate" :disabled="working">
            {{ activeStatusText }}
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
            task: this.dataTask,
            working: false,
            exists: this.dataExists,
        }
    },
    computed: {
        inActiveStatusText() {
            return this.hovering ? 'Disable' : 'Enabled'
        },
        activeStatusText(){
            return this.hovering ? 'Enable' : 'Disabled'
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
