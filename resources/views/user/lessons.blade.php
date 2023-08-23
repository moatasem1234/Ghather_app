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
            <div class="card-header">
            @lang('My lesoon')
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                    <thead>
                    <tr>
                        <th width="10">
                            #
                        </th>
                        <th>
                            @lang('course')
                        </th>
                        <th>
                            @lang('title')
                        </th>
                        <th>
                            @lang('link video')
                        </th>
                        <th>
                            @lang('status')
                        </th>
{{--                        <th>--}}
{{--                            @lang('test')--}}
{{--                        </th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($lessons as $lesson)
                        <tr data-entry-id="{{ $lesson->id }}">
                            <td>
                                {{ $lesson->id }}
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $lesson->course->title }}</span>
                            </td>
                            <td>
                                {{ $lesson->title ?? '' }}
                            </td>
                            <td>
                                <a href=" {{ $lesson->link }}" target="_blank"> {{ $lesson->link }}</a>
                            </td>

                            <td>
                                {{ $lesson->published ? 'Active' : 'InActive' }}
                            </td>
{{--                            <td>--}}
{{--                                <form action="{{ route('lessons.test' ,  [$lesson] )}}" method="POST" >--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="id" value="{{ $lesson->id }}">--}}
{{--                                    <button   type="submit" class="btn  btn-link >--}}
{{--                                         <a class="nav-link @if ($menu == 'Lessons') active @endif">--}}
{{--                                    <i class="nav-icon fa fa-bookmark"></i>--}}
{{--                                    <p> test </p>--}}
{{--                                    </a>--}}
{{--                                    </button>--}}
{{--                                </form>--}}
{{--                            </td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="12">@lang('none')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
    </div>
@endsection
