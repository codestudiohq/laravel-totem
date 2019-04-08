<template>
  <transition mode="out-in">
    <div class="uk-modal uk-flex-top" v-if="show" :class="{ 'uk-open uk-display-block': show}" @click="close">
      <div class="uk-modal-dialog uk-margin-auto-vertical" @click.stop>
        <div class="uk-button uk-button-link uk-modal-close-default" @click="close">
          <span uk-icon="icon: close"></span>
        </div>
        <slot></slot>
      </div>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'UIKitModal',
    props: {
      show: false
    },
    computed: {

    },
    methods: {
      close() {
        this.$emit('close')
      }
    },
    mounted() {
      document.addEventListener("keydown", (e) => {
        if (this.show && e.keyCode === 27) {
          this.close();
        }
      });
    }
  }
</script>