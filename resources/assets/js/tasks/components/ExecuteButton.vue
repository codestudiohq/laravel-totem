<template>
  <transition mode="out-in">
    <button type="button" class="uk-button" :class="buttonClasses" @click="execute" :disabled="running">
      <span v-if="iconName && !running" uk-icon="icon: check; ratio: 1"></span>
      <span v-else>
          <span v-if="!running">Execute</span>
      </span>
      <div v-if="running" uk-spinner="ratio: 1"></div>
    </button>
  </transition>
</template>

<script>
  export default {
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
        this.running = true;

        axios.get(this.url)
            .takeAtLeast(500)
            .then(response => {
              this.task = response.data;
              this.running = false;
              this.$emit('taskExecuted', this.task);
            })
      }
    },
    mounted() {
    }
  }
</script>
