

@php

    use App\Models\Notification;
    use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
             $count = Notification::where('user_id', $user->id)
                 ->where('vist', 1)
                 ->count();
@endphp
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light py-0">

    <div class="container-fluid justify-content-between row-lg">
        <!-- Left elements -->
        <div class="d-flex col-lg-4">
            <!-- Brand -->
            <a class="navbar-brand mx-2 mb-1 d-flex align-items-center shadow rounded-8 p-0" href="{{ url('/profile/' . $user->id) }}">               <div class="rounded-circle">
                   <img class="m-0 rounded-circle " src="{{ asset('images/logos/icon.png') }}" height="60" width="60" alt="MyADC" />
               </div>
            </a>

        </div>
        <!-- Left elements -->

        <!-- Center elements -->
        <ul class="navbar-nav flex-row d-flex justify-content-center col-lg-4">

            <li class="nav-item me-4" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Home">
                <a class="nav-link  @if ($menu == 'Home') active @endif" href="{{ route('home') }}">
                    <span><i class="fas fa-home fa-lg"></i></span>
                </a>
            </li>

            <li class="nav-item  mt-1 me-4" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="My Course">
                <a class="nav-link  @if ($menu == 'My_Courses') active @endif" href="{{ route('User_course.index') }}">
                    <span><i class="fas fa fa-book fa-lg"></i></span>
                </a>
            </li>
            <li class="nav-item mt-1 me-3" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Messenger">
                <a class="nav-link" href="{{ route('chatify') }}">
                    <span><i class="bi bi-chat-square-fill fa-lg"></i></span>
                </a>
            </li>
            <li class="nav-item mt-1 me-3" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Notification">
                <a class="nav-link @if ($menu == 'Notification') active @endif"  href="{{ route('user.notify.to_user') }}">
<span style="position:relative;">
  <i class="fa fa-bell fa-lg"></i>

    @if($count>0 )
    <div style="   font-size: 11px; text-align: center;  height: 15px; width: 15px; background-color:red;  border-radius: 100%; color:white; position:absolute; top:-7px; right:-7px;">
    {{ $count }}
    </div>
    @endif

</span>
                            </g>
                            </svg></span>

                </a>
            </li>
            <li class="nav-item  mt-1 me-4" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Chat-bot Gather">
                <a class="nav-link  @if ($menu == 'Chat-bot') active @endif" href="/chat">
                   <span><i class="fa fa-commenting" aria-hidden="true"></i></span>
                </a>
            </li>

        </ul>
        <!-- Center elements -->


        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>


        <!-- Right elements -->
        <ul class="navbar-nav flex-row justify-content-center justify-content-lg-end collapse navbar-collapse col-lg-4"
            id="navbarTogglerDemo02">

            <li class="nav-item me-3" data-mdb-toggle="tooltip" data-mdb-placement="bottom" title="Profile">
                <a class="nav-link d-sm-flex align-items-sm-center dropdown-toggle hidden-arrow   @if ($menu == Auth::user()->id) active @endif"
                    href="{{ route('user.profile', Auth::user()->id) }}">

                    <img src="@if (Auth::user()->user_image) {{ asset('images/users') . '/' . Auth::user()->user_image }} @else {{ asset('images/asset_img/user-icon.png') }} @endif"
                        class="rounded-circle" height="22" alt="User_photo" loading="lazy" />

                    <strong class="d-none d-sm-block ms-1"
                        style="width: 100px; white-space:nowrap; overflow: hidden; text-overflow: ellipsis; ">{{ Auth::user()->name }}</strong>
                </a>
            </li>

            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink"
                    role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chevron-circle-down fa-lg"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li>
                        <a class="dropdown-item py-1 px-0">

                            <button type="button" class="btn bg-transparent shadow-0 px-3 py-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fas fa-key me-1"></i>
                                Change password
                            </button>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-1 px-0">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" name="logoutform">
                                @csrf

                                <button class="logout btn bg-transparent shadow-0 px-3 py-2" type="submit"
                                    style="font-size: 14px"><i class="fas fa-sign-out-alt me-1"></i> Log out</button>
                            </form>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Right elements -->
    </div>
</nav>


<!-- Change password Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action=" {{ route('user_password.update') }} " method="post">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input id="current_password"
                            class="form-control @error('current_password') is-invalid @enderror" type="password"
                            name="current_password">
                        @error('current_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <label for="password">New Password</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                            type="password" name="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mt-4">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                            name="password_confirmation">
                        @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
