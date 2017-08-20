@extends('totem::layout')
@section('page-title')
    @parent
    - Task
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h5 class="uk-margin-remove">View Task</h5>
        <status-button :data-task="{{ $task }}" :data-exists="{{ $task->exists ? 1 : 0 }}"></status-button>
    </div>
@stop
@section('main-panel-content')
    <ul class="uk-list uk-list-striped">
        <li>Description         : {{$task->description}}</li>
        <li>Command             : {{$task->command }}</li>
        <li>Parameters          : {{$task->parameteres or 'N/A' }}</li>
        <li>Expression          : {{$task->cron }}</li>
        <li>Timezone            : {{$task->timezone }}</li>
        <li>Avoids Overlapping  : {{$task->dont_overlap ? 'Yes' : 'No' }}</li>
        <li>Runs in maintenance mode  : {{$task->run_in_maintenance ? 'Yes' : 'No' }}</li>
        <li>Created@            : {{$task->created_at->toDateTimeString() }}</li>
        <li>Updated@            : {{$task->updated_at->toDateTimeString() }}</li>
        <li>Notification Email  : {{$task->notification_email_address }}</li>
        <li>Average Run Time    : {{$task->results->count() > 0 ? number_format(  $task->results->sum('duration') / (1000 * $task->results->count()) , 2) : '0'}} seconds<br></li>
        <li>Next Run            : {{$task->upcoming }}</li>
    </ul>
@stop
@section('main-panel-footer')
    <div class="uk-card-footer">
        <a href="{{ route('totem.task.run', $task) }}" class="uk-button uk-button-primary uk-button-small">Run</a>
        <a href="{{ route('totem.task.edit', $task) }}" class="uk-button uk-button-primary uk-button-small">Edit</a>
        <form class="uk-display-inline" action="{{route('totem.task.delete', $task)}}" method="post">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <button type="submit" class="uk-button uk-button-danger uk-button-small">Delete</button>
        </form>

    </div>
@stop
@section('additional-panels')
    <div class="uk-card uk-card-default uk-margin-top">
        <div class="uk-card-header">
            <h5>Execution Results</h5>
        </div>
        <div class="uk-card-body uk-padding-remove-top">
            <table class="uk-table uk-table-striped">
                <thead>
                <tr>
                    <th class="pl2">Executed At</th>
                    <th class="pl2">Duration</th>
                </tr>
                </thead>
                <tbody>
                @forelse($results = $task->results()->orderByDesc('created_at')->paginate(10) as $result)
                    <tr>
                        <td class="ph2">{{$result->ran_at->toDateTimeString()}}</td>
                        <td class="ph2">{{ number_format($result->duration / 1000 , 2)}} seconds</td>
                    </tr>
                @empty
                    <tr>
                        <td class="uk-text-center" colspan="5">
                            <p class="pa2">Not executed yet.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="uk-card-footer">
            {{$results->links('totem::partials.pagination')}}
        </div>

    </div>
@stop