@extends('layouts.app')
@php
    $menu = 'My_Courses';
    $rightbarImage = 'notice.png';
@endphp
@section('content')
    <div class="row">
        {{-- Left section started --}}
        <div class="d-none d-lg-block col-lg-3 py-md-4 scroll">

            @include('layouts.includes.leftbar')
        </div>
        {{-- Left section ended --}}
        <div class="col-lg-6 col-md-8 col-sm-12 py-md-4 pt-4 scroll justify-content-center  ">
            <div class="card">
                <div class="card-header">
                    @lang('Assignments')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                            <thead>
                            <tr>
                                <th>
                                    @lang('title')
                                </th>
                                <th>
                                    @lang('description')
                                </th>
                                <th>
                                    @lang('deadline')
                                </th>
                                <th>
                                    @lang('Answer')
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach ($assignments as $assignment)
                                <tr data-entry-id="{{ $assignment->id }}">
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->description }}</td>
                                    <td>{{ $assignment->deadline }}</td>
                                    <td>
                                        <a href="{{ route('user.assignments.answer', ['id' => $assignment->id]) }}">Answer Assignment</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
        {{-- Right section ended --}}
    </div>
@endsection
