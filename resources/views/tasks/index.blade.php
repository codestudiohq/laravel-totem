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
        <button class="btn btn-primary btn-md">New Task</button>
    </div>
@stop
@section('body')
    <table class="table" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="pl2">Task</th>
                <th>Frequency</th>
                <th>Runtime</th>
                <th>Last Run</th>
                <th>Execute</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ph2"></td>
                <td class="ph2"></td>
                <td class="ph2"></td>
                <td class="ph2"></td>
                <td class="ph2"></td>
            </tr>
        </tbody>
    </table>
@stop
