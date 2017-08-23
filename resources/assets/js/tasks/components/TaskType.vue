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
            },
            frequencies: {
                type: Array
            }
        },
        data() {
            return {
                type : this.current,
                showModal: false,
                placeholder: {
                    label : 'Please select a frequency',
                    frequency: false,
                    parameters: false
                },
                selected: {
                    label : 'Please select a frequency',
                    frequency: false,
                    parameters: false
                }
            };
        },
        computed: {
            isValid: function () {
                return this.selected.frequency
            },
            isCron: function () {
                return this.type == 'expression'
            },
            managesFrequencies: function () {
                return this.type == 'frequency'
            }
        },
        methods: {
            addFrequency() {
                console.log(this.isValid)
                if(this.isValid) {
                    this.frequencies.push(this.selected)
                    this.closeModal()
                }
            },
            closeModal() {
                this.showModal = false
            },
            remove(index) {
                this.frequencies.splice(index,1);
            }
        }
    }
</script>
