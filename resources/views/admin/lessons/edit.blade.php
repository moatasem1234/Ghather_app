@extends('admin.layouts.app')
@section('title')
    Lessons
@endsection
<?php $menu = 'Lessons';
$submenu = ''; ?>

@section('content')
<div class="card">
    <div class="card-header">
        @lang('edit_lesson')
    </div>

    <div class="card-body">
        <form action="{{ route('lesson.update', $lesson->id) }}" method="POST">
            @csrf
            @method('put')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="course_id">@lang('course')*</label>
                    <select name="course_id" class="form-control" id="teacher" >
                        @foreach($courses as $course)
                            <option {{ $lesson->course_id ? "selected" : null }} value="{{ $course->id }}">{{ $course->title  }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('title'))
                        <em class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </em>
                    @endif
                </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">@lang('title')*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($lesson) ? $lesson->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
{{--            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">--}}
{{--                <label for="title">@lang('slug')*</label>--}}
{{--                <input type="text" id="title" name="slug" class="form-control" value="{{ old('slug', isset($lesson) ? $lesson->title : '') }}" required>--}}
{{--                @if($errors->has('slug'))--}}
{{--                    <em class="invalid-feedback">--}}
{{--                        {{ $errors->first('slug') }}--}}
{{--                    </em>--}}
{{--                @endif--}}
{{--            </div>--}}
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="link">@lang('link video')*</label>
                <input type="text" id="link" name="link" class="form-control" value="{{ old('link', isset($lesson) ? $lesson->embed_id : '') }}" required />
                @if($errors->has('slug'))
                    <em class="invalid-feedback">
                        {{ $errors->first('slug') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                <label for="published">@lang('status')*</label>
                <select name="published" class="form-control" id="published">
                    <option {{ $lesson->published == 1 ? 'selected' : null }} value="1">@lang('active')</option>
                    <option {{ $lesson->published == 0 ? 'selected' : null }} value="0">@lang('inactive')</option>
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
