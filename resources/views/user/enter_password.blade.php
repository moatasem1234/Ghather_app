@extends('layouts.app')

@section('title')
    Enter Password
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ $test->title }} - Enter Password</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('User_test.submitPassword') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $test->id }}">
                            <div class="form-group row">
                                <label for="exam_password" class="col-md-4 col-form-label text-md-right">Exam Password</label>
                                <div class="col-md-6">
                                    <input id="exam_password" type="password" class="form-control" name="exam_password" required>
                                    @error('exam_password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
