@extends('totem::layout')
@section('page-title')
    @parent
    - KPI
@stop
@section('title')
    <div class="vab">
        <span class="mr2">Key Performance Indicators</span>
    </div>
@stop
@section('body')
    <div class="stats">
        <div class="stat">
            <h2 class="stat-title">Number of Tasks</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                12
            </p>
        </div>
        <div class="stat">
            <h2 class="stat-title">Currently Scheduled</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                2
            </p>
        </div>
        <div class="stat">
            <h2 class="stat-title">Inactive Tasks</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                4
            </p>
        </div>
        <div class="stat">
            <h2 class="stat-title">Active Tasks</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                8
            </p>
        </div>
        <div class="stat stat-last">
            <h2 class="stat-title">Status</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                <span class="stat-value">
                  Inactive
                </span>
            </p>
        </div>
    </div>
    <div class="stats">
        <div class="stat">
            <h2 class="stat-title">Total Processes</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                0
            </p>
        </div>
        <div class="stat">
            <h2 class="stat-title">Max Wait Time</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                -
            </p>
        </div>
        <div class="stat">
            <h2 class="stat-title">Max Runtime</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                default
            </p>
        </div>
        <div class="stat stat-last">
            <h2 class="stat-title">Max Throughput</h2>
            <h3 class="stat-meta">&nbsp;</h3>
            <p class="stat-value">
                default
            </p>
        </div>
    </div>
@stop