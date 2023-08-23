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

                                            <a class="btn btn-xs btn-info" href="{{ route('questions.edit', $question->id) }}">
                                                @lang('edit')
                                            </a>
                                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure ?');" style="display: inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-xs btn-danger" >@lang('delete')</button>
                                            </form>

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
        </div>
        {{-- Center section ended --}}


        {{-- Right section starts --}}
        <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

            @include('layouts.includes.rightbar')

        </div>
        {{-- Right section ended --}}

    </div>
@endsection
