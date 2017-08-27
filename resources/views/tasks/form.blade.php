@extends('totem::layout')
@section('page-title')
    @parent
    - {{ $task->exists ? 'Update' : 'Create'}} Task
@stop
@section('main-panel-before')
    <form action="{{ request()->fullUrl() }}" method="POST" class="uk-form-horizontal">
        {{csrf_field()}}
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h5 class="uk-card-title uk-margin-remove">{{ $task->exists ? 'Update' : 'Create'}} Task</h5>
    </div>
@stop
@section('main-panel-content')
    <div class="uk-margin">
        <label class="uk-form-label">Description</label>
        <div class="uk-form-controls">
            <input class="uk-input" placeholder="A brief description" name="description" id="description" value="{{old('description', $task->description)}}" type="text">
            @if($errors->has('description'))
                <p class="uk-text-danger">{{$errors->first('description')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Command</label>
        <div class="uk-form-controls">
            <select id="command" name="command" class="uk-select" placeholder="Click here to select one of the available commands">
                <option value="">Click here to select one of the available commands</option>
                @foreach ($commands as $command)
                    <option value="{{$command->getName()}}" {{old('command', $task->command) == $command->getName() ? 'selected' : ''}}>{{$command->getDescription()}}</option>
                @endforeach
            </select>
            @if($errors->has('command'))
                <p class="uk-text-danger">{{$errors->first('command')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Parameters</label>
        <div class="uk-form-controls">
            <input class="uk-input" placeholder="Any command parameters required to run the selected command" name="parameters" id="parameters" value="{{old('parameters', $task->parameters)}}" type="text">
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Timezone</label>
        <div class="uk-form-controls">
            <select id="timezone" name="timezone" class="uk-select" placeholder="Click here to select one of the available commands">
                @foreach ($timezones as $key => $timezone)
                    <option value="{{$timezone}}" {{old('timezone', $task->exists ? $task->timezone :  config('app.timezone')) == $timezone ? 'selected' : ''}}>{{$timezone}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <task-type inline-template current="{{old('type', $task->expression ? 'expression' : 'frequency')}}" :existing="{{old('frequencies') ? json_encode(old('frequencies')) : $task->frequencies}}" >
        <div>
            <div class="uk-margin">
                <div class="uk-form-label">Type</div>
                <div class="uk-form-controls uk-form-controls-text">
                    <label>
                        <input type="radio" name="type" v-model="type" value="expression"> Expression
                    </label><br>
                    <label>
                        <input type="radio" name="type" v-model="type" value="frequency"> Frequencies
                    </label>
                </div>
            </div>
            <div class="uk-margin" v-if="isCron">
                <label class="uk-form-label">Cron Expression</label>
                <div class="uk-form-controls">
                    <input class="uk-input" placeholder="e.g * * * * * to run this task all the time" name="expression" id="expression" value="{{old('expression', $task->expression)}}" type="text">
                    @if($errors->has('expression'))
                        <p class="uk-text-danger">{{$errors->first('expression')}}</p>
                    @endif
                </div>
            </div>
            <div class="uk-margin" v-if="managesFrequencies">
                <label class="uk-form-label"></label>
                <div class="uk-form-controls">
                    <a class="uk-button uk-button-small uk-button-link" @click.self.prevent="showModal = true">Add Frequency</a>
                    @include('totem::dialogs.frequencies.add')
                    <table class="uk-table uk-table-divider uk-margin-remove">
                        <thead>
                            <tr>
                                <th class="uk-padding-remove-left">
                                    Frequency
                                </th>
                                <th class="uk-padding-remove-left">
                                    Parameters
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(frequency, index) in frequencies">
                                <td class="uk-padding-remove-left">
                                    @{{ frequency.label }}
                                    <input type="hidden" :name="'frequencies[' + index + '][interval]'" v-model="frequency.interval">
                                    <input type="hidden" :name="'frequencies[' + index + '][label]'" v-model="frequency.label">
                                </td>
                                <td class="uk-padding-remove-left">
                                    <span v-if="frequency.parameters && frequency.parameters.length > 0">
                                        <span v-for="(parameter, key) in frequency.parameters">
                                            @{{ parameter.value }}
                                            <span v-if="frequency.parameters.length > 1 && key < frequency.parameters.length - 1">,</span>
                                            <input type="hidden" :name="'frequencies[' + index + '][parameters][' + key +'][name]'" v-model="parameter.name">
                                            <input type="hidden" :name="'frequencies[' + index + '][parameters][' + key +'][value]'" v-model="parameter.value">
                                        </span>
                                    </span>
                                    <span v-else>
                                        No Parameters
                                    </span>
                                </td>
                                <td>
                                    <a class="uk-button uk-button-link" @click="remove(index)">
                                        <icon name="close" :scale="100"></icon>
                                    </a>
                                </td>
                            </tr>
                            <tr v-if="frequencies.length == 0">
                                <td colspan="3" class="uk-padding-remove-left">No Frequencies Found</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($errors->has('frequencies'))
                        <p class="uk-text-danger">{{$errors->first('frequencies')}}</p>
                    @endif
                </div>
            </div>
        </div>
    </task-type>
    <div class="uk-margin">
        <label class="uk-form-label">Email Notification</label>
        <div class="uk-form-controls">
            <input type="text" id="email" name="notification_email_address" value="{{old('notification_email_address', $task->notification_email_address)}}" class="uk-input" placeholder="Leave empty if you do not wish to receive email notifications">
            @if($errors->has('notification_email_address'))
                <p class="uk-text-danger">{{$errors->first('notification_email_address')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">SMS Notification</label>
        <div class="uk-form-controls">
            <input type="text" id="phone" name="notification_phone_number" value="{{old('notification_phone_number', $task->notification_phone_number)}}" class="uk-input" placeholder="Leave empty if you do not wish to receive sms notifications">
            @if($errors->has('notification_phone_number'))
                <p class="uk-text-danger">{{$errors->first('notification_phone_number')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Slack Notification</label>
        <div class="uk-form-controls">
            <input type="text" id="slack" name="notification_slack_webhook" value="{{old('notification_slack_webhook', $task->notification_slack_webhook)}}" class="uk-input" placeholder="Leave empty if you do not wish to receive slack notifications">
            @if($errors->has('notification_slack_webhook'))
                <p class="uk-text-danger">{{$errors->first('notification_slack_webhook')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-form-label"></div>
        <div class="uk-form-controls uk-form-controls-text">
            <label>
                <input type="hidden" name="dont_overlap" id="dont_overlap" value="0" {{old('dont_overlap', $task->dont_overlap) ? '' : 'checked'}}>
                <input type="checkbox" name="dont_overlap" id="dont_overlap" value="1" {{old('dont_overlap', $task->dont_overlap) ? 'checked' : ''}}>
                Don't Overlap
            </label><br>
            <label>
                <input type="hidden" name="run_in_maintenance" id="run_in_maintenance" value="0" {{old('run_in_maintenance', $task->run_in_maintenance) ? '' : 'checked'}}>
                <input type="checkbox" name="run_in_maintenance" id="run_in_maintenance" value="1" {{old('run_in_maintenance', $task->run_in_maintenance) ? 'checked' : ''}}>
                Run in maintenance mode
            </label>
        </div>
    </div>
@stop
@section('main-panel-footer')
    <button class="uk-button uk-button-primary uk-button-small" type="submit">Save</button>
@stop
@section('main-panel-after')
    </form>
@stop