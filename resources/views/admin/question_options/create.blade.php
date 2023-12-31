@extends('admin.layouts.app')
@section('title')
    Questions_Options
@endsection
<?php $menu = 'Questions_Options';
$submenu = ''; ?>

@section('content')

    <div class="card">
    <div class="card-header">
        @lang('create')
    </div>

    <div class="card-body">
        <form action="{{ route('question_options.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group {{ $errors->has('test') ? 'has-error' : '' }}">
                <label for="question_id">@lang('test')*</label>
                <select name="question_id" class="form-control" id="question_id" >
                    @foreach($questions as $id => $question)
                        <option value="{{ $id }}">{{ $question }}</option>
                    @endforeach
                </select>
                @if($errors->has('question_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('question_id') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('question') ? 'has-error' : '' }}">
                <label for="option_text">@lang('text')*</label>
                <textarea id="option_text" name="option_text" rows="5" class="form-control" required>
                    {{ old('option_text', isset($question_option) ? $question_option->option_text : '') }}
                </textarea>
                @if($errors->has('option_text'))
                    <em class="invalid-feedback">
                        {{ $errors->first('option_text') }}
                    </em>
                @endif
            </div>
            <div class="form-group {{ $errors->has('score') ? 'has-error' : '' }}">
                <label for="correct">@lang('correct')*</label>
                <input type="checkbox" name="correct">
                @if($errors->has('correct'))
                    <em class="invalid-feedback">
                        {{ $errors->first('correct') }}
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
