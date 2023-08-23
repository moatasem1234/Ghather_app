@extends('layouts.app')
@section('title')
    My_Courses |
@endsection
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




        {{-- Center section started --}}
        <div class="col-lg-6 col-md-8 col-sm-12 py-md-4 pt-4 scroll justify-content-center  ">
            @if ($errors->has('exam_password'))
                <div class="alert alert-danger">
                    {{ $errors->first('exam_password') }}
                </div>
            @endif
            <div class="col-lg-12">
                <h1> My Course </h1>
                @foreach ($courses as $course)
                    <div class="col-md-12">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text">{{ $course->description }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $course->start_date }}</small>
                                </div>
                            </div>
                            <div class="justify-content-between d-flex">
                                <form action="{{ route('User_lesson.index' , $course->id) }}" method="POST" >
                                    @csrf
                                        <input type="hidden" name="id" value="{{ $course->id }}">
                                        <button   type="submit" class="btn  btn-link >
                                         <a class="nav-link @if ($menu == 'Lessons') active @endif">
                                        <i class="nav-icon fa fa-bookmark"></i>
                                        <p> Lessons </p>
                                        </a>
                                        </button>
                                </form>
                                <form action="{{ route('User_test.index') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $course->id }}">
                                    <button   type="submit" class="btn  btn-link >
                                         <a class="nav-link @if ($menu == 'Lessons') active @endif">
                                    <i class=" fa fa-question-circle"  ></i>
                                    <p> Test </p>
                                    </a>
                                    </button>
                                </form>



                                <form action="{{ route('user.assignments.index') }}" method="POST" >
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $course->id }}">
                                    <button   type="submit" class="btn  btn-link >
                                         <a class="nav-link @if ($menu == 'Lessons') active @endif">
                                    <i class="nav-icon fa fa-pencil-square"></i>
                                    <p> Assignment </p>
                                    </a>
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- pagination --}}
            </div>
        </div>
        {{-- Center section ended --}}


        {{-- Right section starts --}}
        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
        {{-- Right section ended --}}

    </div>
@endsection
