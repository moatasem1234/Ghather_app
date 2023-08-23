{{-- Left side list --}}

@php
//     $user=\App\Models\User::where('id',Auth::id())->get();
       $user = DB::table('users')->leftjoin('students', 'users.email', 'students.email')->select('users.*', 'students.department')->where('users.id', '=', Auth::user()->id)->first();
       $likes_cnt = DB::table('post_likes')
           ->leftjoin('posts', 'post_likes.post_id', '=', 'posts.id')
           ->where('posts.user_id', $user->id)
           ->count();

                   $posts = DB::table('posts')
                ->leftjoin('users', 'users.id', '=', 'posts.user_id')
                ->select('posts.*', 'users.name', 'users.user_image', 'users.created_at')
                ->where('posts.user_id', '=', Auth::user()->id)
                ->orderBy('posts.post_date', 'desc')
                ->paginate(10);


       $cmnts_cnt = DB::table('post_comments')
           ->leftjoin('posts', 'post_comments.post_id', '=', 'posts.id')
           ->where('posts.user_id', $user->id)
           ->count();

         use App\Models\Notification;
    use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
             $count = Notification::where('user_id', $user->id)
                 ->where('vist', 1)
                 ->count();
          $usercourse=  DB::table('course_user')->where('user_id',$user->id);
@endphp


<div class="list-group list-group-light mb-4">
    <a href="{{ route('User_course.index') }}" class="list-group-item list-group-item-action px-3 border-0">
        <i class="fa fa fa-book fa-lg me-3"></i> My Courses </a>
    <a href="/chat" class="list-group-item list-group-item-action px-3 border-0">
        <i class="fa fa-commenting" aria-hidden="true"></i> Chat-bot </a>

        <a class="list-group-item list-group-item-action px-3 border-0"  href="{{ route('user.notify.to_user') }}">
        <span class="me-3" style="position:relative;">
             <i class="fa fa-bell fa-lg"></i>
             @if($count>0 )
                <div style="   font-size: 11px; text-align: center;  height: 15px; width: 15px; background-color:red;  border-radius: 100%; color:white; position:absolute; top:-7px; right:-7px;">
                    {{ $count }}
                </div>
               @endif
        </span>
            Notifications
        </a>

</div>

<div class="card text-start">
    <div class="card-body">
        <h4 class="card-title text-center"></h4>
        <hr>
        <img class="img-fluid rounded-4" src="{{ asset('images/asset_img/admission.png') }}" alt="">
    </div>
</div>

<div class="card text-start mt-4">
<div class="card-body">
    <ul class="list-group list-group-light">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><i class="fas fa-newspaper fa-lg text-danger me-3"></i> Number of posts</span>
            <span class="badge badge-danger rounded-pill">{{ $posts->count() }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><i class="fas fa-thumbs-up fa-lg text-primary me-3"></i> Number of likes earned</span>
            <span class="badge badge-primary rounded-pill">{{ $likes_cnt }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-comment fa-lg text-success me-3"></i> Number of comments
                                received</span>
            <span class="badge badge-success rounded-pill">{{ $cmnts_cnt }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-clock fa-lg text-info me-3"></i>Joined</span>
            <span class="fw-semibold">{{ date('d F, Y', strtotime($user->created_at)) }}</span>
        </li>
    </ul>
</div>
</div>
