import './bootstrap';
import Vue from 'vue';
import moment from 'moment';
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
import UIKitAlert from './components/UiKitAlert.vue';
import TaskRow from './tasks/components/TaskRow.vue';
import TaskType from './tasks/components/TaskType.vue';
import TaskOutput from './tasks/components/TaskOutput.vue';
import StatusButton from './tasks/components/StatusButton.vue';
import ExecuteButton from './tasks/components/ExecuteButton.vue';
import ImportButton from './tasks/components/ImportButton'

Promise.delay = function (time) {
  return new Promise((resolve, reject) => {
    setTimeout(resolve, time)
  })
};

Promise.prototype.takeAtLeast = function (time) {
  return new Promise((resolve, reject) => {
    Promise.all([this, Promise.delay(time)]).then(([result]) => {
      resolve(result)
    }, reject)
  })
};

Vue.mixin({
  methods: {
    /**
     * Format the given date with respect to timezone.
     */
    formatDate(unixTime){
      return moment(unixTime * 1000).add(new Date().getTimezoneOffset() / 60)
    },

    /**
     * Convert to human readable timestamp.
     */
    readableTimestamp(timestamp){
      return this.formatDate(timestamp).format('HH:mm:ss')
    }
  }
});

new Vue({
  el: '#root',
  components: {
    'uikit-alert'  : UIKitAlert,
    'status-button': StatusButton,
    'execute-button': ExecuteButton,
    'import-button': ImportButton,
    'task-type' : TaskType,
    'task-output' : TaskOutput,
    'task-row': TaskRow,
  },
  mounted() {
    UIkit.use(Icons);
  }
});
