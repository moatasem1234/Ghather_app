@extends('layouts.app')
@section('title')
    My_Courses |
@endsection
@php
    $menu = 'My_Courses';
    $rightbarImage = 'notice.png';
@endphp
@section('content')
    <div class="container">


        <div class="row justify-content-center">

            <div class=" col-md-8">
                <div class="card">
                    @if ($result)
                        <div class="alert alert-success mt-4">
                            Your grade for this test: <b style="color: red;visibility: hidden">{{ $result->score }}</b>
                        </div>
                    @endif
                    <div class="card-body">
                        <p>Time Remaining: <span style="color: #f63f05" id="timer"></span></p>
                        </div>
                    <form id="submit-form"  action="{{ route('User_test.result') }}" method="POST">
                                @csrf
                                @foreach ($questions as $question)
                                    <div class=" mb-4">
                                        <h3 class="card-title">Question: {{ $question->question }}</h3>

                                        @if($question->question_image)
                                            <a href="{{ Storage::url($question->question_image) }}" target="_blank">
                                                <img style="width: 400px;height: 300px" src="{{  asset($question->question_image) }}" alt="Question Image"/>
                                            </a>
                                        @endif

                                        <ul class="list-group">
                                            @foreach ($question->options as $option)
                                                <li class="list-group-item">
                                                    <div class="form-check">
                                                        <input {{ $result ? 'disabled' : '' }} class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" id="option_{{ $option->id }}">
                                                        <label class="form-check-label" for="option_{{ $option->id }}">
                                                            {{ $option->option_text }}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                        <button id="submitBtn" type="submit" {{ $result ? 'disabled' : '' }}  class="btn btn-primary">Submit Answers</button>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ????? ????? jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ??? JavaScript -->
    <script>
        $(document).ready(function() {
            var testDuration = "{{ $test_duration }}";
            var timeArray = testDuration.split(':');
            var hours = parseInt(timeArray[0]);
            var minutes = parseInt(timeArray[1]);
            var seconds = (hours * 3600) + (minutes * 60);

            var countdownFinished = localStorage.getItem('countdownFinished');

            if (!countdownFinished) {
                var x = setInterval(function() {
                    hours = Math.floor(seconds / 3600);
                    minutes = Math.floor((seconds % 3600) / 60);
                    var remainingSeconds = seconds % 60;

                    document.getElementById("timer").innerHTML = hours + "h " + minutes + "m " + remainingSeconds + "s ";

                    if (seconds <= 0) {
                        clearInterval(x);

                        if (!document.getElementById("submitBtn").hasAttribute("disabled")) {
                            document.getElementById("submit-form").submit();
                            localStorage.setItem('countdownFinished', true);
                        }
                    }

                    seconds -= 1;
                }, 1000);
            }
        });


    </script>


@endsection
