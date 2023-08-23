@extends('admin.layouts.app')
@section('title')
    Questions
@endsection
<?php $menu = 'Questions';
$submenu = ''; ?>

@section('content')
    <div class="title d-flex justify-content-between">
        <div>
            <h3 class="page-title">@lang('')</h3>
            <p class="m-0">
            <ul class="d-flex list-unstyled" style="column-gap: 1rem">
                <li><a href="{{ route('questions.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('all')</a></li> |
            </ul>
            </p>
        </div>
        <form action="{{ route('process-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input class="rounded mb-1" type="number" name="random" id="random" placeholder="number of questions">
            <input class="mb-1" type="file"  title="chose Excel File" required name="excel_file">
            <button class="btn btn-primary mb-1" type="submit">Upload Excel</button>
            <select name="test" class="form-control" id="test" >
                @foreach($tests as $id => $test)
                    <option value="{{ $id }}">{{ $test }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="d-flex justify-content-end mt-2">
        <p >
            <a href="{{ route('questions.create') }}" class="btn btn-success">@lang('add question ')</a>
        </p>
    </div>

<div class="card">
    <div class="card-header">
        @lang('view')
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
                            @lang('question')
                        </th>
                        <th>
                            @lang('image')
                        </th>
                        <th>
                            @lang('score')
                        </th>
                        <th>
                            @lang('actions')
                        </th>
                    </tr>
                </thead>
                <tbody>

                @forelse($questions as $question)
                    <tr data-entry-id="{{ $question->id }}">
                        <td>
                        </td>
                        <td>
                            {{ $question->question }}
                        </td>
                        <td>
                            @if($question->question_image)
                                <a href="{{ Storage::url($question->question_image) }}" target="_blank">
                                    <img style="width: 75px;height: 75px" src="{{  asset($question->question_image) }}" alt="Question Image"/>
                                </a>
                            @endif
                        </td>

                        <td>
                            {{ $question->score }}
                        </td>
                        <td>
                        @if( request('show_deleted') == 1 )
                        <form action="{{ route('questions.restore', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-xs btn-info" >@lang('restore')</button>
                        </form>
                        <form action="{{ route('questions.perma_del', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-xs btn-danger" >@lang('delete')</button>
                        </form>
                        @else
                            <a class="btn btn-xs btn-info" href="{{ route('questions.edit', $question->id) }}">
                                @lang('edit')
                            </a>
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
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
