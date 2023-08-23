@include('layouts.includes.head')
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">

<style>

    .falling-text-container {
        position: relative;
        height: 100vh;
        overflow: hidden;
        background-color: #f0f0f0;
    }

    .falling-text-wrapper {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
         height: 100vh;
    }

    .falling-letter {
        font-size: 4rem;
        opacity: 0;
    }

</style>
<body class="bg-light">

    <main class="">

        <div class="container bg-light col-lg-9">


            <div class="d-md-flex justify-content-between">
                <div class="d-flex align-items-center py-2">
                    <div class="shadow rounded-8">
                        <img class="rounded-8" width="" src="{{ asset('images/logos/icon.png') }}" alt="" style="width: 80px">
                    </div>
                    <div class="ms-4">

                        <h1 class="falling-text text-primary mt-3 fw-bold mb-0" >Gather</h1>
                        <p> Interactive Platform</p>
                    </div>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>





            <div class="row mt-3 ">
                <div class="col-md-3 p-5">
{{--                    <img class="img-fluid mb-3" src="{{ asset('images/asset_img/welcome_art.png') }}" alt="">--}}
                </div>
                <div class="col-md-6">
                    <div class="card px-4 py-3 rounded-8 shadow-lg">
                        <div class="card-header">
                            <h2>{{ __('Sign in') }}</h2>
                        </div>
                        <div class="card-body">
                            <div class="confetti"></div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control py-2 @error('email') is-invalid @enderror"
                                        id="email" name="email" aria-describedby="emailHelp">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="exampleInputPassword1" class="form-label">Password</label>
                                    <input type="password"
                                        class="form-control py-2  @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                                </div>

                                <div class="d-md-flex justify-content-md-between pt-3">
                                    <button type="button" class="btn btn-link px-0 forgetPassBtn"
                                            onclick="location.href='{{ route('password.request') }}'" @auth disabled
                                        @endauth>Forgot your password?</button>

                                    <div class="d-flex flex-md-row flex-column align-items-md-center align-items-start">
                                        <div class="d-md-flex me-md-3 mb-md-0 mb-2">
                                            @auth
                                                <a class="btn btn-secondary me-2" href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
                                            @else
                                                <a class="btn btn-grad-primary me-2" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Sign up</a>
                                            @endauth
						       <button type="submit" class="btn-grad-primary" @auth disabled @endauth>
                                            <div class="d-flex align-items-center">Sign in<i class="fas fa-sign-in-alt ms-1"></i></div>
                                        </button>
                                        </div>

                                 
                                    </div>
                                </div>

                            </form>

                        </div>
		</div>
		
  		<div class="mx-auto " style="width: 250px;" >

                <span class="falling-text text-primary fw-bold mb-0 falling-letter" >G</span>
                <span class="falling-text text-primary fw-bold mb-0 falling-letter" >a</span>
                <span class="falling-text text-primary fw-bold mb-0 falling-letter">t</span>
                <span class="falling-text text-primary fw-bold mb-0 falling-letter">h</span>
                <span class="falling-text text-primary fw-bold mb-0 falling-letter">e</span>
                <span class="falling-text text-primary fw-bold mb-0 falling-letter">r</span>
          	</div>
                    </div>
                </div>
            </div>
    
        </div>
  
    </main>


    <footer class="py-3">
        <div class="container">
            <div class="d-md-flex justify-content-center small mt-3">
                <div class="text-muted">&copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>. Developed and supported by
                    <a href="https://github.com/moatasem1234/" target="blank">Moatasem &</a>
                    <a href="https://github.com/Mohsen-it" target="blank"> Abdul Mohsen</a>.
                    <a href="/admin" > Join as Admin</a>.
                </div>
                <div class="ms-1">
                    &middot;
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
    @include('layouts.includes.scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script>
        // ????? ??? ?? ????? ???????
        document.addEventListener("DOMContentLoaded", function () {
            // ???? ??? ?????? ??????
            var screenHeight = window.innerHeight;

            // ??? ?????? ??????? ?? ?????? ??????
            var translateYValue = (screenHeight * 0.5) + "px";

            // ??? ??????? ???????? translateYValue
            anime.timeline({
                loop: false,
            }).add({
                targets: '.falling-letter',
                translateY: translateYValue,
                opacity: 1,
                duration: 1000,
                delay: anime.stagger(100),
                easing: 'easeInOutQuad',
            });
        });
    </script>


</body>

</html>
