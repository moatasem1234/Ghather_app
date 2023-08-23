@extends('admin.layouts.app')
<?php $menu = 'Assignments';
$submenu = ''; ?>



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Assignment') }}</div>

                    <div class="card-body">
                        <form action="{{ route('admin.assignments.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea name="description" id="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="course_id">{{ __('Course') }}</label>
                                <select name="course_id" id="course_id" class="form-control" required>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="deadline">{{ __('Deadline') }}</label>
                                <input type="datetime-local" name="deadline" id="deadline" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
