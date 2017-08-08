@extends('totem::layout')
@section('page-title')
    @parent
    - Task
@stop
@section('title')
    <div class="vab">
        Task
    </div>
    <div>
        <button class="btn btn-md btn-primary">Run</button>
        <status-button :data-task="{{ $task }}" :data-exists="{{ $task->exists ? 1 : 0 }}" class="mr-2"></status-button>
        <a href="{{route('totem.task.edit', $task)}}" class="btn btn-md btn-primary">Edit</a>
    </div>
@stop
@section('main-panel-content')
    <div class="pa2">
        <div class="frame ">
            <div class="blk2 ft15 lh2 basic-text tar">
                Description<br>
                Command<br>
                Type<br>
                Created At<br>
                Updated At<br>
                Notification Email
            </div>
            <div class="blk9 ft15 lh2 basic-text">
                {{$task->description}}<br>
                {{$task->command}}<br>
                {{$task->cron ? 'Cron ( ' . $task->cron . ' )': 'Frequency'}}<br>
                {{$task->created_at->toDateTimeString()}}<br>
                {{$task->updated_at->toDateTimeString()}}<br>
                {{$task->notification_email_address}}
            </div>
        </div>
    </div>
@stop
@section('additional-panels')
    <div class="panel panel-default">
        <div class="panel-heading">
            Task Stats
        </div>
        <div class="panel-content">


        </div>
    </div>
@stop