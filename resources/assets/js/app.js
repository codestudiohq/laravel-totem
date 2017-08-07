import './bootstrap';
import Vue from 'vue';
import moment from 'moment';

Promise.delay = function (time) {
    return new Promise((resolve, reject) => {
        setTimeout(resolve, time)
    })
}

Promise.prototype.takeAtLeast = function (time) {
    return new Promise((resolve, reject) => {
        Promise.all([this, Promise.delay(time)]).then(([result]) => {
            resolve(result)
        }, reject)
    })
}

Vue.component('status-button', require('./tasks/components/StatusButton.vue'));

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
            return this.formatDate(timestamp).format('HH:mm:ss');
        }
    }
});

new Vue({
    el: '#root'
});
