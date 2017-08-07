@extends('totem::layout')
@section('page-title')
    @parent
    - {{ $task->exists ? 'Update' : 'Create'}} Task
@stop
@section('title')
    <div class="vab">
        <span class="mr2">{{ $task->exists ? 'Update' : 'Create'}} Task</span>
    </div>
    <status-button :data-task="{{ $task }}" :data-exists="{{ $task->exists ? 1 : 0 }}" class="mr-2"></status-button>
@stop
@section('body')
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
          {!! Form::select('command', $commands , null , ['class' => 'form-control', 'placeholder' => 'Click here to select one of the available commands']) !!}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">

        </p>
        <div class="blk6">
            <label class="ft15">
            	{!! Form::radio('type', 'cron', old('type', 'cron'),  ['id' => 'type']) !!}
            	Cron
            </label>
            <label class="ft15">
            	{!! Form::radio('type', 'frequency', old('type', 'cron'),  ['id' => 'type']) !!}
            	Frequency
            </label>
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Cron Expression</label>
        </p>
        <div class="blk6">
            {!! Form::text('cron', old('cron', $task->cron), ['class' => 'form-control', 'placeholder' => 'e.g * * * * * to run this task all the time']) !!}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar"></p>
        <div class="blk6">
            <label class="pl2 ft15">
            	{!! Form::checkbox('dont_overlap', '1', old('dont_overlap', $task->dont_overlap),  ['id' => 'dont_overlap']) !!}
            	Do not Overlap
            </label>
            <label class="pl2 ft15">
            	{!! Form::checkbox('run_in_maintenance', '1', old('run_in_maintenance', $task->run_in_maintenance), ['id' => 'run_in_maintenance']) !!}
            	Run in Maintenance Mode
            </label>
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
</form>
@stop