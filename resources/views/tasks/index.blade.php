@extends("totem::layout")
@section('page-title')
    @parent
    - Tasks
@stop
@section('title')
    <div class="uk-flex uk-flex-between uk-flex-middle">
        <h4 class="uk-card-title uk-margin-remove">Tasks</h4>
        {!! Form::open([
            'id' => 'totem__search__form',
            'url' => Request::fullUrl(),
            'method' => 'GET',
            'class' => 'uk-display-inline uk-search uk-search-default'
        ]) !!}
        <span uk-search-icon></span>
        {!! Form::text('q', request('q'), ['class' => 'uk-search-input', 'placeholder' => 'Search...']) !!}
        {!! Form::close() !!}
    </div>
@stop
@section('main-panel-content')
    <table class="uk-table uk-table-responsive" cellpadding="0" cellspacing="0" class="mb1">
        <thead>
            <tr>
                <th>{!! Html::columnSort('Description', 'description') !!}</th>
                <th>Average Runtime</th>
                <th>Last Run</th>
                <th>Next Run</th>
                <th class="uk-text-center">Execute</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr class="{{$task->is_active ?: 'uk-text-danger'}}">
                    <td>
                        <a href="{{route('totem.task.view', $task)}}">
                            {{str_limit($task->description, 30)}}
                        </a>
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Command</span>
                    </td>
                    <td>
                        {{ number_format(  $task->averageRuntime / 1000 , 2 ) }} seconds
                        <span class="uk-float-right uk-hidden@s uk-text-muted">Avg. Runtime</span>
                    </td>
                    @if($last = $task->lastResult)
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
                    <td class="uk-text-center@m">
                        <execute-button :data-task="{{$task}}" url="{{route('totem.task.execute', $task)}}" icon-name="play" button-class="uk-button-link"></execute-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="uk-text-center" colspan="5">
                        <img class="uk-svg" width="50" height="50" src="{{asset('/vendor/totem/img/funnel.svg')}}">
                        <p>No Tasks Found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop
@section('main-panel-footer')
    <div class="uk-flex uk-flex-between">
        <span>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: plus" href="{{route('totem.task.create')}}"></a>
            <a class="uk-button uk-button-primary uk-button-small uk-visible@m" href="{{route('totem.task.create')}}">New Task</a>
        </span>

        <span>
            <import-button url="{{route('totem.tasks.import')}}"></import-button>
            <a class="uk-icon-button uk-button-primary uk-hidden@m" uk-icon="icon: cloud-download"  href="{{route('totem.tasks.export')}}"></a>
            <a class="uk-button uk-button-primary uk-button-small uk-visible@m" href="{{route('totem.tasks.export')}}">Export</a>
        </span>
    </div>
    {{$tasks->links('totem::partials.pagination')}}
@stop