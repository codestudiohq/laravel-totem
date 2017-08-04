<script type="text/ecmascript-6">
    import _ from 'lodash';
    import axios from 'axios';
    import moment from 'moment';
    import Layout from '../layouts/MainLayout.vue';
    import Panel from '../components/Panels/Panel.vue';
    import Status from '../components/Status/Status.vue';
    import Spinner from '../components/Loaders/Spinner.vue';
    import PanelHeading from '../components/Panels/PanelHeading.vue';
    import PanelContent from '../components/Panels/PanelContent.vue';

    export default {
        components: {Layout, Spinner, Status, Panel, PanelContent, PanelHeading},


        /**
         * The component's data.
         */
        data(){
            return {
                loadingStats: true,
                loadingWorkers: true,
                loadingWorkload: true,
                stats: {},
                workers: [],
                workload: [],
            };
        },


        /**
         * Prepare the component.
         */
        mounted() {
            document.title = "Totem - Dashboard";
        },

        methods: {

        }
    }
</script>

<template>
    <layout>
        <section class="main-content">
            <panel :loading="loadingStats" class="mb3">
                <panel-heading>Overview</panel-heading>

                <panel-content>
                    <div class="stats">
                        <div class="stat">
                            <h2 class="stat-title">Jobs Per Minute</h2>
                            <h3 class="stat-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                        <div class="stat">
                            <h2 class="stat-title">Jobs past hour</h2>
                            <h3 class="stat-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                        <div class="stat">
                            <h2 class="stat-title">Failed Jobs past hour</h2>
                            <h3 class="stat-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                    </div>
                    <div class="stats">
                        <div class="stat">
                            <h2 class="stat-title">Total Processes</h2>
                            <h3 class="state-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                        <div class="stat">
                            <h2 class="stat-title">Max Wait Time</h2>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                        <div class="stat">
                            <h2 class="stat-title">Max Runtime</h2>
                            <h3 class="state-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                        <div class="stat stat-last">
                            <h2 class="stat-title">Max Throughput</h2>
                            <h3 class="state-meta">&nbsp;</h3>
                            <p class="stat-value">
                                Some Stat
                            </p>
                        </div>
                    </div>
                </panel-content>
            </panel>
        </section>
    </layout>
</template>
