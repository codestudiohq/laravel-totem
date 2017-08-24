@extends("totem::layout")
@section('page-title')
    @parent
    - Tasks
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h4 class="uk-card-title uk-margin-remove">Tasks</h4>
        <form class="uk-display-inline uk-search uk-search-default">
            <span class="uk-icon uk-search-icon">
                <icon name="search" :scale="100"></icon>
            </span>

            <input class="uk-search-input" type="search" placeholder="Search...">
        </form>
    </div>
@stop
@section('main-panel-content')
    <table class="uk-table uk-table-responsive" cellpadding="0" cellspacing="0" class="mb1">
        <thead>
            <tr>
                <th>Command</th>
                <th>Average Runtime</th>
                <th>Last Run</th>
                <th>Next Run</th>
                <th>Execute</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr class="{{$task->is_active ?: 'uk-text-danger'}}">
                    <td>
                        <a href="{{route('totem.task.view', $task)}}">
                            {{$task->command}}
                        </a>
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Command</span>
                    </td>
                    <td>
                        {{  $task->results->count() > 0 ? number_format(  $task->results->sum('duration') / (1000 * $task->results->count()) , 2) : '0' }} seconds
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Avg. Runtime</span>
                    </td>
                    @if($last = $task->results->last())
                        <td>
                            {{$last->ran_at->toDateTimeString()}}
                            <span class="uk-float-right uk-hidden@s uk-text-muted">Last Run</span>
                        </td>
                    @else
                        <td>
                            N/A
                            <span class="uk-float-right uk-hidden@s uk-text-muted">Last Run</span>
                        </td>
                    @endif
                    <td>
                        {{$task->upcoming}}
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Next Run</span>
                    </td>
                    <td>
                        <a href="{{ route('totem.task.run', $task) }}">
                            <icon name="cog" :scale="100" class="uk-visible@s"></icon>
                            <span class="uk-hidden@s">Execute</span>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="uk-text-center" colspan="5">
                        <img class="uk-svg" width="50" height="50" src="/vendor/totem/img/funnel.svg">
                        <p>No Tasks Found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop
@section('main-panel-footer')
    <a class="uk-button uk-button-primary uk-button-small" href="{{route('totem.task.create')}}">New Task</a>
    {{$tasks->links('totem::partials.pagination')}}
@stop