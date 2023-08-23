@extends('admin.layouts.app')
@section('title')
    Tests
@endsection
<?php $menu = 'Tests';
$submenu = ''; ?>

@section('content')
    <div class="title d-flex justify-content-between">
        <h3 class="page-title">@lang('')</h3>
        <p>
            <a href="{{ route('tests.create') }}" class="btn btn-success">@lang('add test')</a>
        </p>
    </div>

    <p class="m-0">
    <ul class="d-flex list-unstyled" style="column-gap: 1rem">
        <li><a href="{{ route('tests.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('all')</a></li>
    </ul>
    </p>

    <div class="card">
        <div class="card-header">
            @lang('view')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Location">
                    <thead>
                    <tr>
                        <th width="10">#</th>
                        <th>@lang('course')</th>
                        <th>@lang('lesson')</th>
                        <th>@lang('title')</th>
                        <th>@lang('password')</th>
                        <th>@lang('duration')</th>
                        <th>@lang('description')</th>
                        <th>@lang('published')</th>
                        <th>@lang('actions')</th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tests as $test)
                        <tr data-entry-id="{{ $test->id }}">
                            <td>{{ $test->id }}</td>
                            <td>{{ $test->course->title ?? '' }}</td>
                            <td>{{ $test->lesson->title ?? '' }}</td>
                            <td>{{ $test->title }}</td>
                            <td>{{ $test->password }}</td>
                            <td>{{ $test->duration }}</td>
                            <td>{!! $test->description !!}</td>
                            <td>{{ $test->published ? 'Active' : 'InActive' }}</td>
                            <td>
                                @if( request('show_deleted') == 1 )
                                    <form action="{{ route('tests.restore', $test->id) }}" method="POST" onsubmit="return confirm(@lang('admin/test.areyousure'));" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-info">@lang('restore')</button>
                                    </form>
                                    <form action="{{ route('tests.perma_del', $test->id) }}" method="POST" onsubmit="return confirm(@lang('admin/test.areyousure'));" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger">@lang('delete')</button>
                                    </form>
                                @else
                                    <a class="btn btn-xs btn-info" href="{{ route('tests.edit', $test->id) }}">@lang('edit')</a>
                                    <form action="{{ route('tests.destroy', $test->id) }}" method="POST" onsubmit="return confirm(@lang('admin/test.areyousure'));" style="display: inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-xs btn-danger">@lang('delete')</button>
                                    </form>
                                @endif
                                <a class="btn btn-xs btn-primary" href="{{ route('tests.view_grades', $test->id) }}">@lang('view_grades')</a>
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
