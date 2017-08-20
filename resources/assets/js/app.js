import './bootstrap'
import Vue from 'vue'
import moment from 'moment'
import Vuikit from 'vuikit'
import StatusButton from './tasks/components/StatusButton.vue'
import VkAlert from './components/UiKitAlert.vue'

import IconCog from 'vuikit/icons/cog'
import IconClose from 'vuikit/icons/close'
import IconClock from 'vuikit/icons/clock'
import IconSearch from 'vuikit/icons/search'
import IconSpinner from 'vuikit/icons/components/spinner'


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

Vuikit.Icon.register(IconCog)
Vuikit.Icon.register(IconClose)
Vuikit.Icon.register(IconClock)
Vuikit.Icon.register(IconSearch)
Vuikit.Icon.register(IconSpinner)

Vue.component('status-button', StatusButton)
Vue.component('vk-alert',VkAlert)
Vue.use(Vuikit)
new Vue({
    el: '#root'
})
