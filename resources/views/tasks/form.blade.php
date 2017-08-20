@extends('totem::layout')
@section('page-title')
    @parent
    - {{ $task->exists ? 'Update' : 'Create'}} Task
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h5 class="uk-margin-remove">{{ $task->exists ? 'Update' : 'Create'}} Task</h5>
    </div>
@stop
@section('main-panel-content')
<form action="{{ request()->fullUrl() }}" method="POST" class="uk-form-horizontal">
    {{csrf_field()}}
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
                @foreach ($commands as $key => $command)
                    <option value="{{$key}}" {{old('command', $task->command) == $key ? 'selected' : ''}}>{{$command}}</option>
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
                    <option value="{{$timezone}}" {{old('timezone', $task->timezone) == $timezone ? 'selected' : ''}}>{{$timezone}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="uk-margin">
        <div class="uk-form-label">Type</div>
        <div class="uk-form-controls uk-form-controls-text">
            <label><input type="radio" name="type" id="type" value="cron" {{old('type', 'cron') == 'cron' ? 'checked' : ''}}> Cron</label><br>
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Cron Expression</label>
        <div class="uk-form-controls">
            <input class="uk-input" placeholder="e.g * * * * * to run this task all the time" name="cron" id="cron" value="{{old('cron', $task->cron)}}" type="text">
            @if($errors->has('cron'))
                <p class="uk-text-danger">{{$errors->first('cron')}}</p>
            @endif
        </div>
    </div>
    <div class="uk-margin">
        <label class="uk-form-label">Notification Email</label>
        <div class="uk-form-controls">
            <input type="email" id="email" name="notification_email_address" value="{{old('notification_email_address', $task->notification_email_address)}}" class="uk-input" placeholder="Leave empty if you do not wish to receive email notifications">
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
    <button class="uk-button uk-button-primary uk-button-small" type="submit">Save</button>
</form>
@stop