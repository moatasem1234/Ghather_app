@extends('admin.layouts.app')
@section('title')
    Questions_Options
@endsection
<?php $menu = 'Questions_Options';
$submenu = ''; ?>

@section('content')

    <div class="title d-flex justify-content-between">
        <h3 class="page-title">@lang('view')</h3>
        <p >
            <a href="{{ route('question_options.create') }}" class="btn btn-success">@lang('add option')</a>
        </p>
   </div>

    <p class="m-0">
        <ul class="d-flex list-unstyled" style="column-gap: 1rem">
            <li><a href="{{ route('question_options.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang(' all')</a></li>
        </ul>
    </p>

<div class="card">
    <div class="card-header">
        @lang(' name')
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
                            @lang(' question')
                        </th>
                        <th>
                            @lang(' text')
                        </th>
                        <th>
                            @lang(' correct')
                        </th>
                        <th>
                            @lang(' actions')
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($question_options as $question_option)
                    <tr data-entry-id="{{ $question_option->id }}">
                        <td>
                        </td>
                        <td>{{ $question_option->question->question ?? '' }}</td>
                        <td>{!! $question_option->option_text !!}</td>
                        <td>{{ $question_option->correct == 1 ? 'true' : 'false' }}</td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('question_options.restore', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >@lang(' restore')</button>
                        </form>
                        <form action="{{ route('question_options.perma_del', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >@lang(' delete')</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('question_options.edit', $question_option->id) }}">
                                @lang(' edit')
                            </a>
                            <form action="{{ route('question_options.destroy', $question_option->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
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
