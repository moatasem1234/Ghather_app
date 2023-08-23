@extends('admin.layouts.app')
@section('title')
    Courses
@endsection
<?php $menu = 'Courses';
$submenu = ''; ?>


@section('content')
<div class="card">
    <div class="card-header">
        Edit Courses
    </div>

    <div class="card-body">
        <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">@lang('title')*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($course) ? $course->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="description">@lang('description')*</label>
                <textarea id="description" name="description" rows="5" class="form-control" required>
                    {{ old('description', isset($course) ? $course->description : '') }}
                </textarea>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
{{--            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">--}}
{{--                <label for="link">@lang('link')*</label>--}}
{{--                <input type="text" id="link" name="link" class="form-control" value="{{ old('link', isset($course) ? $course->link : '') }}" />--}}
{{--                @if($errors->has('slug'))--}}
{{--                    <em class="invalid-feedback">--}}
{{--                        {{ $errors->first('slug') }}--}}
{{--                    </em>--}}
{{--                @endif--}}
{{--            </div>--}}
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="start_date">@lang('start')*</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', isset($course) ? $course->start_date : '') }}" required />
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="status">@lang('status')*</label>
                <select name="status" class="form-control" id="status">
                    <option {{ $course->status == 'Active' ? 'selected' : null }} value="1">Active</option>
                    <option {{ $course->status  == 'Inactive' ? 'selected' : null }} value="0">In Active</option>
                </select>
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>

            <div>
                <button class="btn btn-danger" type="submit" >@lang('save')</button>
            </div>
        </form>
    </div>
</div>
@endsection
