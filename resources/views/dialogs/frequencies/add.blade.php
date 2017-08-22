<uikit-modal :show="showModal" @close="closeModal">
    <div class="uk-modal-header">
        <h4 class="uk-modal-title">Add Frequency</h4>
    </div>
    <div class="uk-modal-body">
        <select id="frequency" class="uk-select" placeholder="Select a type of frequency" v-model="frequency">
            @foreach (collect($frequencies) as $key => $frequency)
                <option :value="{{ json_encode($frequency) }}">{{$frequency['label']}}</option>
            @endforeach
        </select>
    </div>
    <div class="uk-modal-footer">
        <div class="uk-flex uk-flex-right">
            <a class="uk-button uk-button-small uk-button-primary" @click="addFrequency">Add</a>
        </div>
    </div>
</uikit-modal>