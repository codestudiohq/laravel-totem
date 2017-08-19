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
        <status-button :data-task="{{ $task }}" :data-exists="{{ $task->exists ? 1 : 0 }}" class="mr-2"></status-button>
    </div>
@stop
@section('main-panel-content')
    <div class="pa2">
        <div class="frame ">
            <div class="blk2 ft15 lh2 tcg9 tar">
                Description<br>
                Command<br>
                Cron Expression<br>
                Timezone<br>
                Created @<br>
                Updated @<br>
                Notify @<br>
                Average Run Time
            </div>
            <div class="blk9 ft15 lh2 basic-text">
                {{$task->description}}<br>
                {{$task->command}}<br>
                {{$task->cron ? $task->cron : 'Frequency'}}<br>
                {{$task->timezone}}<br>
                {{$task->created_at->toDateTimeString()}}<br>
                {{$task->updated_at->toDateTimeString()}}<br>
                {{$task->notification_email_address}}<br>
                {{$task->results->count() > 0 ? number_format(  $task->results->sum('duration') / (1000 * $task->results->count()) , 2) : '0'}} seconds
            </div>
        </div>
    </div>
@stop
@section('main-panel-footer')
    <div class="pv1 pl2 df">
        <a href="{{ route('totem.task.run', $task) }}" class="btn btn-md btn-primary mr1">Run</a>
        <a href="{{ route('totem.task.edit', $task) }}" class="btn btn-md btn-primary mr1">Edit</a>
        <form class="dib" action="{{route('totem.task.delete', $task)}}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button type="submit" class="btn btn-md btn-primary">Delete</button>
        </form>

    </div>
@stop
@section('additional-panels')
    <div class="panel panel-default">
        <div class="panel-heading">
            Execution Results
        </div>
        <div class="panel-content">
            <table class="table" cellpadding="0" cellspacing="0" class="mb1">
                <thead>
                <tr>
                    <th class="pl2">Duration</th>
                    <th class="pl2">Executed At</th>
                </tr>
                </thead>
                <tbody>
                @forelse($results = $task->results()->paginate(10) as $result)
                    <tr>
                        <td class="ph2">{{ number_format($result->duration / 1000 , 2)}} seconds</td>
                        <td class="ph2">{{$result->ran_at->toDateTimeString()}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="tac" colspan="5">
                            <p class="pa2">Not executed yet.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="panel-footer">
            {{$results->links()}}
        </div>

    </div>
@stop