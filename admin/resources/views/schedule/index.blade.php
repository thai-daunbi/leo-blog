@extends('layouts.app')

@section('title', 'Schedule Management')

@section('content_header')
    <h1><i class="fa fa-calendar"></i> Schedule Management</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">List of Schedule</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->title }}</td>
                        <td>{{ $schedule->date }}</td>
                        <td>{{ $schedule->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
