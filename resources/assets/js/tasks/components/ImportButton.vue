<template>
  <span class="js-upload" uk-form-custom>
    <input type="file">
    <button class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: cloud-upload" type="button"></button>
    <button class="uk-button uk-button-primary uk-button-small uk-visible@m" type="button">
      <span v-if="importing" uk-spinner="ratio: 1"></span>
      <span v-else>Import</span>
    </button>
  </span>
</template>

<script>
  import UIkit from 'uikit';
  export default {
    props: {
      url: {
        type: String,
        required: true
      },
    },
    data() {
      return {
        importing: false,
      }
    },
    computed: {
    },
    methods: {
    },
    mounted() {
      UIkit.upload('.js-upload', {
        url: this.url,
        method: "POST",
        name: "tasks",
        beforeSend: function (environment) {
          environment.headers['X-CSRF-TOKEN'] = window.axios.defaults.headers.common['X-CSRF-TOKEN'];
        },
        beforeAll: function () {
          this.importing = true;
        },
        completeAll: function () {
          this.importing = false;
          window.location.reload(true);
        }
      });
    }
  }
</script>