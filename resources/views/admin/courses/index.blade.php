@extends('admin.layouts.app')
@section('title')
    Courses
@endsection
<?php $menu = 'Courses';
$submenu = ''; ?>

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">@lang('')</h3>

        <p >
            <a href="{{ route('courses.create') }}" class="btn btn-success">@lang('add course')</a>
        </p>

    </div>
    <p class="m-0">
    <ul class="d-flex list-unstyled" style="column-gap: 1rem">
        <li><a href="{{route('courses.index')}}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('all')</a></li> |
        <li><a href="{{route('courses.index')}}" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('trash')</a></li>
    </ul>
    </p>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                    <thead>
                    <tr>
                        <th width="10">
                            #
                        </th>
                        {{--                            @if(auth()->user()->isAdmin())--}}
                        {{--                            <th>--}}
                        {{--                                @lang('admin/course.teacher')--}}
                        {{--                            </th>--}}
                        {{--                            @endif--}}
                        <th>
                            @lang('title')
                        </th>
                        <th>
                            @lang('description')
                        </th>
                        {{--                            <th>--}}
                        {{--                                @lang('link')--}}
                        {{--                            </th>--}}
                        <th>
                            @lang('start')
                        </th>
                        <th>
                            @lang('status')
                        </th>
                        <th>
                            @lang('actions')
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $key => $course)
                        <tr data-entry-id="{{ $course->id }}">
                            <td>

                            </td>

                            <td>
                                <a  href="{{ route('course.students.show', $course->id) }}">
                                    {{ $course->title ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $course->description ?? '' }}
                            </td>
                            {{--                            <td>--}}
                            {{--                                <a target="_blank" href= "{{ $course->link ??''}}">{{ $course->link ??''}}</a>--}}
                            {{--                            </td>--}}
                            <td>
                                {{ $course->start_date }}
                            </td>
                            <td>
                                {{ $course->status }}
                            </td>
                            <td>
                                @if( request('show_deleted') == 1 )
                                    <form action="{{ route('admin/courses.restore', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-info" >Restore</button>
                                    </form>
                                    <form action="{{ route('courses.perma_del', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                                    </form>
                                @else
                                    <a class="btn btn-xs btn-info" href="{{ route('courses.edit', $course->id) }}">
                                        @lang('edit')
                                    </a>
                                    <a class="btn btn-xs btn-success" href="{{ route('courses.show', $course->id) }}">
                                        @lang('view')
                                    </a>
                                    {{--                                    <a class="btn btn-xs btn-danger" href="{{ route('courses.export-pdf', $course->id) }}">--}}
                                    {{--                                        @lang('export')--}}
                                    {{--                                    </a>--}}
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger" >@lang('delete')</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
