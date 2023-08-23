@extends('admin.layouts.app')
<?php $menu = 'Assignments';
$submenu = ''; ?>


@section('content')
    <div class="container">
        <div class="title d-flex justify-content-between">
            <h3 class="page-title">@lang('')</h3>

            <p >
                <a href="{{ route('admin.assignments.create') }}" class="btn btn-success">@lang('add Assignment')</a>
            </p>

        </div>
        <h1>{{ __('Assignments') }}</h1>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th>{{ __('Course') }}</th>
                    <th>{{ __('Deadline') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->title }}</td>
                        <td>{{ $assignment->description }}</td>
                        <td>
                            @if($assignment->course)
                                {{ $assignment->course->title }}
                            @endif
                        </td>
                        <td>{{ $assignment->deadline }}</td>
                        <td> <form action="{{ route('assignment.perma_del', $assignment->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-xs btn-danger" >Delete</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
