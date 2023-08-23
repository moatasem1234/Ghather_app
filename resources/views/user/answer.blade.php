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
            @if ($errors->has('submission_error'))
                <div class="alert alert-danger">{{ $errors->first('submission_error') }}</div>
            @endif
            @if ($errors->has('submission_success'))
                <div class="alert alert-success">{{ $errors->first('submission_success') }}</div>
            @endif
            <div class="card">
              <h1  > @lang('Answer')</h1>
                <div class="card-header">
                <h3>{{$assignment->title}}</h3>
                    <label>Grade:
                        <label style="color: rgba(255,83,83,0.88)">
                        @if($existingAnswer)
                            {{ $existingAnswer->grade }}
                        @else
                            Waiting
                        @endif
                        </label>
                    </label>


                </div>
                <div class="card-body">
                    <form action="{{ route('user.assignments.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
{{--                        <div>--}}
{{--                            <label  for="answer">Your Answer:</label>--}}
{{--                            <textarea name="answer" id="answer" rows="4" cols="43" required></textarea>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="answer">Your Answer:</label>
                            <textarea name="answer" id="answer" rows="4" cols="43" required>{{ $existingAnswer ? old('answer', $existingAnswer->answer) : '' }}</textarea>
                        </div>
                        <button class="btn-grad-primary" style="margin-left: 100px" type="submit">Submit Answer</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
    </div>
@endsection
