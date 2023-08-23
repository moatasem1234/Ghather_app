@extends('layouts.app')
@section('title')
Notification |
@endsection
@php
$menu = 'Notification';
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
        <div class="col-lg-12">
            <h1>Notifications</h1>
            @foreach ($notifications as $notification)
            <div class="col-md-12">
                <div class="card mb-4 ">
                    <div class="card-body">
                        <div>

                            <div class="d-flex justify-content-between align-items-center">
                                <form id="notificationForm" action=" {{route('user.notify.update') }} " method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$notification->id}}">
                                    <p >
                                        {{ $notification->message }}
                                    </p>
                                </form>
                                </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <div>
                                <form action="{{ route('user.notify.destroy') }} " method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$notification->id}}">
                                    <div class="d-flex justify-content-end m-2 ">
                                        <button type="submit" class="btn btn-danger" style="width: 82px ; height: 35px; font-size: 11px " href="">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-3 col-md-4 py-md-4 pt-4 scroll">

        @include('layouts.includes.rightbar')

    </div>

</div>
@endsection