@extends('admin.layouts.app')
@section('title')
    Tests
@endsection
<?php $menu = 'Tests';
$submenu = ''; ?>

@section('content')
<div class="card">
    <div class="card-header">
        @lang('create')
    </div>

    <div class="card-body">
        <form action="{{ route('tests.store') }}" method="POST">
            @csrf
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="course_id">@lang('course')*</label>
                <select name="course_id" class="form-control" id="teacher" >
                    @foreach($courses as $id => $course)
                        <option value="{{ $id }}">{{ $course }}</option>
                    @endforeach
                </select>
                @if($errors->has('course_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('course_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="lesson_id">@lang('lesson')*</label>
                <select name="lesson_id" class="form-control" id="lesson_id" >
                    @foreach($lessons as $id => $lesson)
                        <option value="{{ $id }}">{{ $lesson }}</option>
                    @endforeach
                        <option value=""> non </option>
                </select>
                @if($errors->has('lesson_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('lesson_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">@lang('title')*</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', isset($test) ? $test->title : '') }}" required>
                @if($errors->has('title'))
                    <em class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="title">@lang('password')*</label>
                <input type="text" id="password" name="password" class="form-control" value="{{ old('password', isset($test) ? $test->password : '') }}" required>
                @if($errors->has('password'))
                    <em class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                <label for="duration">@lang('duration')*</label>
                <input type="text" id="duration" name="duration" class="form-control" value="{{ old('duration', isset($test) ? $test->duration : '') }}" required>
                @if($errors->has('duration'))
                    <em class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                <label for="description">@lang('description')*</label>
                <textarea id="description" name="description" rows="5" class="form-control" required>
                    {{ old('description', isset($test) ? $test->description : '') }}
                </textarea>
                @if($errors->has('description'))
                    <em class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('published') ? 'has-error' : '' }}">
                <label for="published">@lang('published')*</label>
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
