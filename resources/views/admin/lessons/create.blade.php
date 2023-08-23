@extends('admin.layouts.app')
@section('title')
    Lessons
@endsection
<?php $menu = 'Lessons';
$submenu = ''; ?>

@section('content')
<div class="card">
    <div class="card-header">
        @lang('create')
    </div>

    <div class="card-body">
        <form action="{{ route('lesson.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="course_id">@lang('Course')*</label>
                    <select name="course_id" class="form-control" id="course_id" >
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
            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
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
{{--                <em class="invalid-feedback">--}}
{{--                        {{ $errors->first('slug') }}--}}
{{--                    </em>--}}
{{--                @endif--}}
{{--            </div>--}}
            <div class="form-group {{ $errors->has('link') ? 'has-error' : '' }}">
                <label for="link">@lang('link video')*</label>
                <input type="text" id="link" name="link" class="form-control" value="{{ old('link', isset($lesson) ? $lesson->embed_id : '') }}" required />
                @if($errors->has('embed_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('embed_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
                <label for="published">@lang('status')*</label>
                <select name="published" class="form-control" id="published">
                    <option value="1">@lang('active')</option>
                    <option value="0">@lang('inactive')</option>
                </select>
                @if($errors->has('published'))
                    <em class="invalid-feedback">
                        {{ $errors->first('published') }}
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
