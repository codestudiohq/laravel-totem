@extends('totem::layout')
@section('page-title')
    @parent
    - {{ $task->exists ? 'Update' : 'Create'}} Task
@stop
@section('title')
    <div class="vab">
        <span class="mr2">{{ $task->exists ? 'Update' : 'Create'}} Task</span>
    </div>
@stop
@section('main-panel-content')
<form action="{{ request()->fullUrl() }}" method="POST" class="pa2">
    {{csrf_field()}}
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Description</label>
        </p>
        <div class="blk6">
            <input class="form-control" placeholder="A brief description" name="description" id="description" value="{{old('description', $task->description)}}" type="text">
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="command">Command</label>
        </p>
        <div class="blk6">
            <select id="command" name="command" class="form-control" placeholder="Click here to select one of the available commands">
            @foreach ($commands as $key => $command)
                <option value="{{$key}}" {{old('command', $task->command) == $command ? 'selected' : ''}}>{{$command}}</option>
            @endforeach
            </select>

            @if($errors->has('command'))
                <p class="tcdanger ft14">{{$errors->first('command')}}</p>
            @endif
        </div>

    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar"></p>
        <div class="blk6">
            <label class="ft15">
                <input type="radio" name="type" id="type" value="cron" {{old('type') == 'cron' ? 'checked' : ''}}>
            	Cron
            </label>
            {{--<label class="ft15">--}}
                {{--<input type="radio" name="type" id="type" value="frequency" {{old('type') == 'cron' ? 'checked' : ''}}>--}}
            	{{--Frequency--}}
            {{--</label>--}}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Cron Expression</label>
        </p>
        <div class="blk6">
            <input class="form-control" placeholder="e.g * * * * * to run this task all the time" name="cron" id="cron" value="{{old('cron', $task->cron)}}" type="text">
            @if($errors->has('cron'))
                <p class="tcdanger ft14">{{$errors->first('cron')}}</p>
            @endif
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Notification Email</label>
        </p>
        <div class="blk6">
            <input type="email" id="email" name="notification_email_address" value="{{old('notification_email_address', $task->notification_email_address)}}" class="form-control" placeholder="Leave empty if you do not wish to receive email notifications">
        </div>
    </div>
    <div class="frame mb2">
        <div class="blk2"></div>
        <div class="blk6">
            <button class="btn btn-md btn-primary" type="submit">Save</button>
        </div>
    </div>
</form>
@stop