@extends("totem::layout")
@section('page-title')
    @parent
    - Tasks
@stop
@section('title')
    <div class="vab">
        <span class="mr2">Tasks</span>
    </div>
    <div class="toolbar">
        <div class="dib search">
            <input type="text" class="search-input" placeholder="Search Tasks">
        </div>
    </div>
@stop
@section('main-panel-content')
    <table class="table" cellpadding="0" cellspacing="0" class="mb1">
        <thead>
            <tr>
                <th class="pl2">Task</th>
                <th class="pl2">Type</th>
                <th class="pl2">Average Runtime</th>
                <th class="pl2">Last Run</th>
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
                    <td class="ph2">{{$task->cron ? 'Cron' : 'Frequency'}}</td>
                    <td class="ph2">N/A</td>
                    <td class="ph2">N/A</td>
                    <td class="ph2">
                        <a href="{{ route('totem.task.run', $task) }}">
                            <i class="ico ico20 ico-baseline">
                                <svg>
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#zondicon-cog"></use>
                                </svg>
                            </i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="tac" colspan="5">

                        <img class="pa2" src="/vendor/totem/img/funnel.svg">
                        <p class="pa2">No Tasks Found.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop
@section('main-panel-footer')

    <div class="pv1 pl2 df">
        <a class="btn btn-md btn-primary" href="{{route('totem.task.create')}}">New Task</a>
    </div>

@stop