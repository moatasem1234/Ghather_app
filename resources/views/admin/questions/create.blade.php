@extends('admin.layouts.app')
@section('title')
    Questions
@endsection
<?php $menu = 'Questions';
$submenu = ''; ?>

@section('content')
<div class="card">
    <div class="card-header">
        @lang('create')
    </div>

    <div class="card-body">
        <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                <label for="question">@lang('Question')*</label>
                <textarea id="question" name="question" rows="3" class="form-control" required>{{ old('question', isset($question) ? $question->question : '') }}</textarea>
                @if($errors->has('question'))
                    <em class="invalid-feedback">
                        {{ $errors->first('question') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('question_image') ? 'has-error' : '' }}">
                <label for="question_image">@lang('Image')*</label>
                <input type="file" id="question_image" name="question_image" class="form-control" />
                @if($errors->has('question_image'))
                    <em class="invalid-feedback">
                        {{ $errors->first('question_image') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('score') ? 'has-error' : '' }}">
                <label for="score">@lang('Score')*</label>
                <input type="number" id="score" name="score" class="form-control" value="{{ old('score', isset($question) ? $question->score : '') }}" required />
                @if($errors->has('score'))
                    <em class="invalid-feedback">
                        {{ $errors->first('score') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('test') ? 'has-error' : '' }}">
                <label for="test">@lang('Test')*</label>
                <select name="test[]" class="form-control" id="test" >
                    @foreach($tests as $id => $test)
                        <option value="{{ $id }}">{{ $test }}</option>
                    @endforeach
                </select>
                @if($errors->has('test'))
                    <em class="invalid-feedback">
                        {{ $errors->first('test') }}
                    </em>
                @endif
            </div>

            @for ($question = 1; $question <= 4; $question++)
                <div class="card card-footer">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="{{ 'option_text_' . $question }}">@lang('Option')*</label>
                            <textarea id="{{ 'option_text_' . $question }}" name="{{ 'option_text_' . $question }}" rows="2" style="width: 100%;" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="{{ 'correct_' . $question }}">@lang('Correct')</label>
                            <input type="checkbox" name="{{ 'correct_' . $question }}">
                        </div>
                    </div>
                </div>
            @endfor

            <div class="mt-3">
                <button class="btn btn-primary" type="submit">@lang('Save')</button>
            </div>
        </form>
    </div>

</div>
@endsection
