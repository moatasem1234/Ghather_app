@extends('layouts.app')
@section('title')
    My Courses |
@endsection
@php
    $menu = 'My_Courses';
    $rightbarImage = 'notice.png';
@endphp

@section('content')
    <div class="row">
        @if ($errors->has('invalid_password'))
            <div class="alert alert-danger">{{ $errors->first('invalid_password') }}</div>
        @endif

        <div class="col-lg-3 col-md-4  py-md-4 pt-4 scroll">
            @include('layouts.includes.leftbar')
        </div>

        <div class="col-lg-6 col-md-8  py-md-4 pt-4 scroll">
            <div class="card">
                <div class="card-header">
                    @lang('tests')
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($errors->has('exam_password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('exam_password') }}
                            </div>
                        @endif
                        <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                            <thead>
                            <tr>
                                <th>
                                    @lang('course')
                                </th>
                                <th>
                                    @lang('lesson')
                                </th>
                                <th>
                                    @lang('title')
                                </th>
                                <th>
                                    @lang('duration')
                                </th>
                                <th>
                                    @lang('description')
                                </th>
                                <th>
                                    @lang('actions')
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($tests as $test)
                                <tr data-entry-id="{{ $test->id }}">
                                    <td>{{ $test->course->title ?? '' }}</td>
                                    <td>{{ $test->lesson->title ?? '' }}</td>
                                    <td>{{ $test->title }}</td>
                                    <td>{{ $test->duration }}</td>
                                    <td>{!! $test->description !!}</td>
                                    <td>
                                        <form action="{{ route('User_test.question.show') }}" method="post" style="display: inline-block;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$test->id}}">
                                            <div class="d-flex">
                                                <input style="width: 80px" class="form-control" type="text" name="enteredPassword" id="enteredPassword" placeholder="@lang('password')">
                                                <button type="submit" class="btn btn-primary ml-2">@lang('view')</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">@lang('not')</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">
            @include('layouts.includes.rightbar')
        </div>
    </div>
@endsection
