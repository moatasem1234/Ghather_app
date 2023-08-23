@extends('admin.layouts.app')
@section('title')
    send
@endsection
<?php $menu = 'send notification';
$submenu = ''; ?>

@section('content')


    <div class="card">

        <div class="card">

            <form action="{{ route('admin.notify.store') }}" method="POST">
                @csrf

                <div class="card-body">
                    <div class="table-responsive">
                        <div class="card-body">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="course_id">@lang('Select Course')</label>
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
<div class="md-form">
  <i class="fas fa-pencil-alt prefix"></i>
  <textarea name="message" id="form10" class="md-textarea form-control" rows="9"></textarea>
 </div>
                                                
  </div>

                    </div>

                    <div>
                        <button class="btn btn-danger" type="submit" >@lang('send')</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
