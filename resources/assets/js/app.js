import './bootstrap'
import Vue from 'vue'
import moment from 'moment'
import Vuikit from 'vuikit'
import StatusButton from './tasks/components/StatusButton.vue'

import IconCog from 'vuikit/icons/cog'
import IconClock from 'vuikit/icons/clock'
import IconSearch from 'vuikit/icons/search'


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
})
console.log(Vuikit)

Vuikit.Icon.register(IconCog)
Vuikit.Icon.register(IconClock)
Vuikit.Icon.register(IconSearch)

Vue.component('status-button', StatusButton)

Vue.use(Vuikit)
new Vue({
    el: '#root'
})
