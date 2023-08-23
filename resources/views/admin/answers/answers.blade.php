@extends('admin.layouts.app')
@section('title')
    Courses
@endsection
<?php $menu = 'Answers';
$submenu = ''; ?>

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Answers: {{ $assignment->title }}</h1>
                <form action="{{ route('answers.update', $assignment->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم الطالب</th>
                            <th>الإجابة</th>
                            <th>الدرجة</th>
                            <th>التأخير</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($answers as $answer)
                            <tr>
                                <td>{{ $answer->id }}</td>
                                <td>{{ $answer->user->name }}</td>
                                <td>{{ $answer->answer }}</td>
                                <td>
                                    <input type="text" name="grades[{{ $answer->id }}]" value="{{ $answer->grade }}">
                                </td>
                                <td style="color: red">
                                    {{ $delay }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">حفظ التعديلات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
