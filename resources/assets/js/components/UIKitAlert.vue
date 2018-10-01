<template>
  <div :class="classes" v-if="show">
    <a class="uk-alert-close uk-close uk-icon" @click="show = false">
      <span uk-icon="icon: close"></span>
    </a>
    <slot></slot>
  </div>
</template>

<script>
  export default {
    name: 'UIKitAlert',
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
