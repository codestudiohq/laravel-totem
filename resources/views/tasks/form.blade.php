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
            {!! Form::text('description', old('description', $task->description), ['class' => 'form-control', 'placeholder' => 'A brief description']) !!}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="command">Command</label>
        </p>
        <div class="blk6">
            {!! Form::select('command', $commands , old('command', $task->command) , ['class' => 'form-control', 'placeholder' => 'Click here to select one of the available commands']) !!}
            @if($errors->has('command'))
                <p class="tcdanger ft14">{{$errors->first('command')}}</p>
            @endif
        </div>

    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar"></p>
        <div class="blk6">
            <label class="ft15">
            	{!! Form::radio('type', 'cron', old('type', $task->cron ? true : false ),  ['id' => 'type']) !!}
            	Cron
            </label>
            {{--<label class="ft15">--}}
            	{{--{!! Form::radio('type', 'frequency', old('type', $task->cron ? false : true),  ['id' => 'type']) !!}--}}
            	{{--Frequency--}}
            {{--</label>--}}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Cron Expression</label>
        </p>
        <div class="blk6">
            {!! Form::text('cron', old('cron', $task->cron), ['class' => 'form-control', 'placeholder' => 'e.g * * * * * to run this task all the time']) !!}
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
            {!! Form::email('notification_email_address', old('notification_email_address', $task->notification_email_address), ['class' => 'form-control', 'placeholder' => 'Leave empty if you do not wish to receive email notifications']) !!}
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