@extends("totem::layout")
@section('page-title')
    @parent
    - Tasks
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h4 class="uk-margin-remove">Tasks</h4>
        <form class="uk-display-inline uk-search uk-search-default">
            <span class="uk-icon uk-search-icon">
                <img src="/vendor/totem/img/icons/search.svg" width="15" height="15">
            </span>
            <input class="uk-search-input" type="search" placeholder="Search...">
        </form>
    </div>
@stop
@section('main-panel-content')
    <div class="uk-overflow-auto">
    <table class="uk-table" cellpadding="0" cellspacing="0" class="mb1">
        <thead>
            <tr>
                <th class="pl2">Command</th>
                <th class="pl2">Average Runtime</th>
                <th class="pl2">Last Run</th>
                <th class="pl2">Next Run</th>
                <th class="pl2">Execute</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td class="ph2">
                        <a href="{{route('totem.task.view', $task)}}">
                            {{$task->command}}
                        </a>
                    </td>
                    <td class="ph2">{{  $task->results->count() > 0 ? number_format(  $task->results->sum('duration') / (1000 * $task->results->count()) , 2) : '0' }} seconds</td>
                    @if($last = $task->results->last())
                        <td class="ph2">{{$last->ran_at->toDateTimeString()}}</td>
                    @else
                        <td class="ph2">N/A</td>
                    @endif
                    <td class="ph2">{{$task->upcoming}}</td>
                    <td class="ph2">
                        <a href="{{ route('totem.task.run', $task) }}">
                            <img src="/vendor/totem/img/icons/cog.svg" width="20" height="20" uk-svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="uk-text-center" colspan="5">
                        <img class="uk-svg" width="50" height="50" src="/vendor/totem/img/funnel.svg">
                        <p class="pa2">No Tasks Found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>
@stop
@section('main-panel-footer')
    <div class="uk-card-footer">
        <a class="uk-button uk-button-primary uk-button-small" href="{{route('totem.task.create')}}">New Task</a>
    </div>
@stop