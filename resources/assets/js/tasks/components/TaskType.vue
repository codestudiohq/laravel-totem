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
            },
            existing: {
                type: Array
            },
            placeholder: {
                type: Object,
                default() {
                    return {
                        label : 'Please select a frequency',
                        interval: false,
                        parameters: false
                    }
                }
            }
        },
        data() {
            return {
                type : this.current,
                frequencies: this.existing,
                showModal: false,
                selected: this.placeholder
            };
        },
        computed: {
            isValid: function () {
                return this.selected.interval
            },
            isCron: function () {
                return this.type === 'expression'
            },
            managesFrequencies: function () {
                return this.type === 'frequency'
            }
        },
        methods: {
            addFrequency() {
                if(this.isValid) {
                    this.frequencies.push(this.selected);
                    this.closeModal()
                }
            },
            closeModal() {
                this.selected = this.placeholder;
                this.showModal = false
            },
            remove(index) {
                this.frequencies.splice(index, 1)
            }
        }
    }
</script>
