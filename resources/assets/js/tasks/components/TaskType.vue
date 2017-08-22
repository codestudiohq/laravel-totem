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
                placeholder: {
                    label : 'Please select a frequency',
                    value: false,
                    parameters: false
                },
                frequency: {
                    label : 'Please select a frequency',
                    value: false,
                    parameters: false
                },
                frequencies: []
            };
        },
        computed: {
            isValid: function () {
                return this.frequency.value
            },
            isCron: function () {
                return this.type == 'cron'
            },
            managesFrequencies: function () {
                return this.type == 'frequency'
            }
        },
        methods: {
            addFrequency() {
                if(this.isValid) {
                    this.frequencies.push(this.frequency)
                    this.closeModal()
                }
            },
            closeModal() {
                this.showModal = false
            },
            remove(index) {
                this.frequencies.splice(index,1);
            }
        },
        mounted() {

        }
    }
</script>
