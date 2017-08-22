<template>

</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'cron'
            },
        },
        data() {
            return {

            };
        },
        computed: {
            isCron: function () {
                return this.type == 'cron'
            },
            hasFrequencies: function () {
                return this.type == 'frequency'
            }
        },
        methods: {

        }
    }
</script>
