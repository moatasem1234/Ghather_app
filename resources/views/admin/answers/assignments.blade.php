@extends('admin.layouts.app')
@section('title')
    Courses
@endsection
<?php $menu = 'Answers';
$submenu = ''; ?>

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="text-center">قائمة المهام للكورس: {{ $course->name }}</h1>
                <ul class="list-group mt-4">
                    @foreach ($assignments as $assignment)
                        <li class="list-group-item">
                            <a href="{{ route('admin.answers.answers', $assignment->id) }}">{{ $assignment->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
