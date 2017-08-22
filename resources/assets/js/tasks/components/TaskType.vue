<script>
    import UIKitModal from '../../components/UIKitModal.vue'
    import Icon from '../../components/Icon.vue'

    export default {
        components: {
            'uikit-modal':UIKitModal,
            'icon'  : Icon
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
                frequency: {
                    label : 'Please select a frequency',
                    value: '-',
                    parameters: false
                },
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
                this.closeModal()
            },
            closeModal() {
                this.showModal = false
            },
            remove(index) {
                this.frequencies.splice(index,1);
            }
        },
        mounted() {
            console.log(this.current)
            console.log(this.frequency)
        }
    }
</script>
