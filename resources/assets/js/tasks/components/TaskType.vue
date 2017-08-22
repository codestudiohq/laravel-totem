<script>
    import UIKitModal from '../../components/UIKitModal.vue'
    export default {
        components: {
          'uikit-modal':UIKitModal
        },
        props: {
            current: {
                type: String,
                default: 'frequency'
            }
        },
        data() {
            return {
                type : this.current,
                showModal: false,
                frequency: {},
                parameters: false,
                frequencies: []
            };
        },
        computed: {
            isCron: function () {
                return this.type == 'cron'
            },
            managesFrequencies: function () {
                return this.type == 'frequency'
            }
        },
        methods: {
            addFrequency() {
                this.frequencies.push(this.frequency)
            },
            closeModal() {
                this.showModal = false
            }
        },
        mounted() {
            console.log(this.current)
        }
    }
</script>
