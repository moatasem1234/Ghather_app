@extends('layouts.app')
@section('title')
    Notice |
@endsection
@php
    $menu = 'Notice';
    $rightbarImage = 'notice.png';
@endphp
@section('content')
    <div class="row pt-8">

        {{-- Left section started --}}
        <div class="d-none d-lg-block col-lg-3 py-md-4 scroll">

            @include('layouts.includes.leftbar')
        </div>
        {{-- Left section ended --}}


        <div class="card  col-lg-6 col-md-8 py-md-4 pt-4 scroll justify-content-center d-flex">
            <section class="section question">
                <div class="question-data">
                                <div class="alert alert-info">@lang('courses.Your test score'): {{ $test_result->test_result }}</div>
                                <form action="{{ route('lessons.test', [$lesson->slug]) }}" method="post">
                                    @csrf
                                    @foreach ($lesson->test->questions as $question)
                                        <h3 for="question" style="margin-bottom: 1.2rem">
                                            {{ $loop->iteration }}. {{ $question->question }}
                                        </h3>

                                        @foreach ($question->options as $option)
                                            <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" style="margin-bottom: 0.8rem" /> {{ $option->option_text }}
                                            <br />
                                        @endforeach
                                    @endforeach

                                    <button class="button"
                                            style="border: none; padding: 0.4rem 1.4rem; border-radius: 1rem;margin-top: 1rem;" >@lang('courses.Submit Result')</button>
                                </form>
                </div>
            </section>
    </div>

        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
    </div>
@endsection
