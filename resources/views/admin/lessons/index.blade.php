@extends('admin.layouts.app')
@section('title')
    Lessons
@endsection
<?php $menu = 'Lessons';
$submenu = ''; ?>

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">@lang('')</h3>
          <p >
            <a href="{{ route('lesson.create') }}" class="btn btn-success">@lang('add lesson')</a>

        </p>

   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
        <li><a href="{{ route('lesson.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('all Lessons')</a></li>
    </ul>
    </p>

<div class="card">
    <div class="card-header">
        @lang('name')
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
                        <th>
                            @lang('actions')
                        </th>
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
                            <a href=" {{ $lesson->link }}"> {{ $lesson->link }}</a>
                        </td>
                        <td>
                            {{ $lesson->published ? 'Active' : 'InActive' }}
                        </td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('lesson.restore', $lesson->id) }}" method="POST" onsubmit="return confirm(@lang('admin/lesson.areyousure'));" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >@lang('restore')</button>
                        </form>
                        <form action="{{ route('lesson.perma_del', $lesson->id) }}" method="POST" onsubmit="return confirm(@lang('admin/lesson.areyousure'));" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >@lang('delete')</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('lesson.edit', $lesson->id) }}">
                                @lang('edit')
                            </a>
                            <form action="{{ route('lesson.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm(@lang('admin/lesson.areyousure'));" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-danger" >@lang('delete')</button>
                            </form>
                        @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="12">@lang('not')</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
