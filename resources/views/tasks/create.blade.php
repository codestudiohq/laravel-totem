@extends('totem::layout')
@section('page-title')
    @parent
    - Create Task
@stop
@section('title')
    <div class="vab">
        <span class="mr2">Create Task</span>
    </div>
@stop
@section('body')
<form action="{{ request()->fullUrl() }}" method="POST">
    {{csrf_field()}}

    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="description">Description</label>
        </p>
        <div class="blk8">
            {!! Form::text('description', old('description', $task->description), ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="frame mb2">
        <p class="blk2 ft15 lh2 basic-text tar">
            <label for="command">Command</label>
        </p>
        <div class="blk8">
          {!! Form::select('command', $commands , null , ['class' => 'form-control']) !!}
        </div>
    </div>
</form>
@stop