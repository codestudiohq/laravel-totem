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
                <vk-icon icon="search"></vk-icon>
            </span>

            <input class="uk-search-input" type="search" placeholder="Search...">
        </form>
    </div>
@stop
@section('main-panel-content')
    <table class="uk-table uk-table-responsive" cellpadding="0" cellspacing="0" class="mb1">
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
                <tr class="{{$task->is_active ?: 'uk-text-danger'}}">
                    <td class="ph2">
                        <a href="{{route('totem.task.view', $task)}}">
                            {{$task->command}}
                        </a>
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Command</span>
                    </td>
                    <td class="ph2">
                        {{  $task->results->count() > 0 ? number_format(  $task->results->sum('duration') / (1000 * $task->results->count()) , 2) : '0' }} seconds
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Avg. Runtime</span>
                    </td>
                    @if($last = $task->results->last())
                        <td class="ph2">
                            {{$last->ran_at->toDateTimeString()}}
                            <span class="uk-float-right uk-hidden@s uk-text-muted">Last Run</span>
                        </td>
                    @else
                        <td class="ph2">
                            N/A
                            <span class="uk-float-right uk-hidden@s uk-text-muted">Last Run</span>
                        </td>
                    @endif
                    <td class="ph2">
                        {{$task->upcoming}}
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Next Run</span>
                    </td>
                    <td class="ph2">
                        <a href="{{ route('totem.task.run', $task) }}">
                            <vk-icon icon="cog" class="uk-visible@s"></vk-icon>
                            <span class="uk-hidden@s">Execute</span>
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
@stop
@section('main-panel-footer')
    <a class="uk-button uk-button-primary uk-button-small" href="{{route('totem.task.create')}}">New Task</a>
    {{$tasks->links('totem::partials.pagination')}}
@stop