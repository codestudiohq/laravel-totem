<template>
    <tr :class="task.is_active ? '' : 'uk-text-danger'">
        <td>
            <a :href="showHref">
                {{ description }}
            </a>
            <span class="uk-float-right uk-hidden@s uk-text-muted">Command</span>
        </td>
        <td>
            {{ task.average_runtime ? averageDurationInSeconds : 0 }} seconds
            <span class="uk-float-right uk-hidden@s uk-text-muted">Avg. Runtime</span>
        </td>
        <td>
            {{ task.last_result ? lastRunDate : 'N/A' }}
            <span class="uk-float-right uk-hidden@s uk-text-muted">Last Run</span>
        </td>
        <td>
            {{task.upcoming}}
            <span class="uk-float-right uk-hidden@s uk-text-muted">Next Run</span>
        </td>
        <td class="uk-text-center@m">
            <execute-button
                :data-task="task"
                :url="executeHref"
                v-on:taskExecuted="refreshTask"
                icon-name="play"
                button-class="uk-button-link"
            />
        </td>
    </tr>
</template>

<script>
    import moment from 'moment'
    import ExecuteButton from './ExecuteButton'

    export default {
        components: {
            ExecuteButton
        },

        props: {
            dataTask: {},
        },

        data() {
            return {
                task: this.dataTask
            }
        },

        computed: {
            description() {
                return this.task.description.substring(0,29);
            },

            averageDurationInSeconds() {
                return this.task.average_runtime > 0 ? (this.task.average_runtime / 1000).toFixed(2) : 0;
            },

            lastRunDate() {
                return moment(this.task.last_result.ran_at).format('YYYY-MM-DD HH:mm:ss');
            },

            showHref() {
                return this.$attrs.showhref;
            },

            executeHref() {
                return this.$attrs.executehref;
            }
        },

        methods: {
            refreshTask(task) {
                this.task = task;
            }
        }
    }
</script>
