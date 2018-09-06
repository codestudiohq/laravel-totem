<template>
  <transition mode="out-in">
    <button v-if="task.activated" type="button" class="uk-button uk-button-small" :class="{ 'uk-button-primary': !hovering && !working, 'uk-button-danger': hovering && !working, 'uk-spinner uk-icon uk-button-secondary': working}" key="enabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="deactivate" :disabled="working">
      <span v-if="!working">{{ activeStatusText }}</span>
      <div v-if="working" uk-spinner="ratio: 1"></div>
    </button>
    <button v-if="existsAndIsInActive" type="button" class="uk-button uk-button-small" :class="{'uk-button-danger': !hovering && !working, 'uk-button-primary': hovering && !working, 'uk-spinner uk-icon uk-button-secondary': working}" key="disabled" @mouseenter="hovering = true" @mouseleave="hovering = false" @click="activate" :disabled="working">
      <span v-if="!working">{{ inActiveStatusText }}</span>
      <div v-if="working" uk-spinner="ratio: 1"></div>
    </button>
  </transition>
</template>

<script>
  export default {
    props: {
      dataTask: {
        type: Object,
        default: null
      },
      dataExists : {
        type: Boolean,
        required: false
      },
      activateUrl : {
        type: String,
        required: true
      },
      deactivateUrl : {
        type: String,
        required: true
      }
    },
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
      activeStatusText() {
        return this.hovering ? 'Disable' : 'Enabled'
      },
      existsAndIsInActive() {
        return !this.task.activated && this.exists;
      }
    },
    methods: {
      activate() {
        this.working = true;

        axios.post(this.activateUrl, {
          task_id: this.dataTask.id
        }).takeAtLeast(500)
            .then(response => {
              this.task = response.data;
              this.working = false;
              this.hovering = false
            })
      },
      deactivate() {
        this.working = true;

        axios.delete(this.deactivateUrl)
            .takeAtLeast(500)
            .then(response => {
              this.task = response.data;
              this.working = false;
              this.hovering = false
            })
      },
    },
    mounted() {
    }
  }
</script>
