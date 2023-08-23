{{--@extends('admin.layouts.app')--}}
{{--@section('title')--}}
{{--    Student_Courses--}}
{{--@endsection--}}
{{--<?php $menu = 'Student_Courses';--}}
{{--$submenu = ''; ?>--}}

{{--@section('content')--}}


{{--<div class="card">--}}
{{--    <div class="card-header">--}}
{{--        @lang('course_student')--}}
{{--    </div>--}}
{{--    <div class="card">--}}
{{--        @if($relationError)--}}
{{--            <div class="alert alert-danger">--}}
{{--                {{ $relationError }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <form action="{{ route('cu.store') }}" method="POST">--}}
{{--            @csrf--}}

{{--            <div class="card-body">--}}
{{--                <div class="table-responsive">--}}
{{--                     <div class="card-body">--}}
{{--                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">--}}
{{--                        <label for="course_id">@lang('Select Course')</label>--}}
{{--                        <select name="course_id" class="form-control" id="course_id" >--}}
{{--                            @foreach($courses as $course)--}}
{{--                                <option value="{{ $course->id }}">{{ $course->title }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @if($errors->has('course_id'))--}}
{{--                            <em class="invalid-feedback">--}}
{{--                                {{ $errors->first('course_id') }}--}}
{{--                            </em>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <table class="table table-bordered table-striped table-hover datatable datatable-Location">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th width="10">--}}
{{--                            #--}}
{{--                        </th>--}}
{{--                        <th>--}}
{{--                            @lang('name')--}}
{{--                        </th>--}}
{{--                        <th>--}}
{{--                            @lang('email')--}}
{{--                        </th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    <div class="form-group ml-4">--}}
{{--                        @foreach($users as $user)--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <div class="form-check">--}}
{{--                                        <input style="width: 1.5rem ; height: 1.5rem "  class="form-check-input" type="checkbox" value="{{$user->id}}" name="checkboxes[]">--}}
{{--                                    </div>--}}
{{--                                </td>--}}

{{--                                <td>--}}
{{--                                    {{ $user->name }}--}}
{{--                                </td>--}}
{{--                                <td>--}}
{{--                                    {{ $user->email }}--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}

{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--                <div>--}}
{{--                    <button class="btn btn-danger" type="submit" >@lang('save')</button>--}}
{{--                </div>--}}
{{--        </div>--}}

{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}

@extends('admin.layouts.app')
@section('title')
    Student_Courses
@endsection
<?php $menu = 'Student_Courses';
$submenu = ''; ?>

@section('content')

    <div class="card-body">
        <form action="{{ route('cu.store') }}" method="POST">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="course_id">@lang('Select Course')</label>
                <select name="course_id" class="form-control" id="course_id">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('course_id') }}
                    </em>
                @endif
            </div>

            <div class="form-group">
                <label for="filter">Filter:</label>
                <input type="text" class="form-control" id="filter" placeholder="Enter name">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                    <thead>
                    <tr>
                        <th width="10">
                            #
                        </th>
                        <th>
                            @lang('name')
                        </th>
                        <th>
                            @lang('email')
                        </th>
                        <th>
                            @lang('action')
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <div class="form-group ml-4">
                        @foreach($users as $user)
                            <tr class="filter-row">
                                <td>
                                    <div class="form-check">
                                        <input style="width: 1.5rem ; height: 1.5rem " class="form-check-input" type="checkbox" value="{{$user->id}}" name="checkboxes[]">
                                    </div>
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <form action="{{ route('cu.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="POST">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </div>
                    </tbody>
                </table>
            </div>
            <div>
                <button class="btn btn-danger" type="submit">@lang('save')</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filter').keyup(function() {
                var value = $(this).val().toLowerCase();
                $('.filter-row').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection

