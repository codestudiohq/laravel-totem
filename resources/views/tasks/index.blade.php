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
        <a class="btn btn-md btn-primary" href="{{route('totem.task.create')}}">New Task</a>
    </div>
@stop
@section('main-panel-content')
    <table class="table" cellpadding="0" cellspacing="0">
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
                        <button class="btn btn-sm btn-secondary">Run</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No Tasks Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@stop
