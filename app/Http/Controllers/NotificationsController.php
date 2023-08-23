<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\Store;
class NotificationsController extends Controller
{
    public function index()
    {
        $courses =Course::all();
        return view('admin.notification.index', compact('courses'));
    }

    public function store(Request $request)
    {

        $message = $request->input('message');
        $users = Course::find($request->course_id)->students;
        foreach ($users as $user) {
            $user->notifications()->create([
                'message' => $message
            ]);
        }

       return redirect()->route('admin.notify.index')->with('success', 'تم إرسال الإشعار بنجاح');

    }

    public function create()
    {
        return view('notifications.send-notification');
    }
    public function to_user()
    {
        $user = Auth::user();

        $peoples = DB::table('users')
            ->inRandomOrder()
            ->paginate(10);

        $count = Notification::where('user_id', $user->id)
            ->where('vist', 0)
            ->count();
        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        // تحديث قيمة count إذا كان هناك إشعارات غير مقروءة

        return view('user.notification', compact('notifications', 'count','peoples'));
    }

    public function update(Request $request)
    {
        $id= $request->id;
        $notification = Notification::find($id);

        $notification->vist = 0; // قيمة جديدة للحقل الboolean
        $notification->save();

        return redirect()->route('user.notify.to_user')->with('success', 'تم إرسال الإشعار بنجاح');
    }
    public function destroy( Request $request)
    {
        $id= $request->id;
        $notification = Notification::find($id);
        $notification->delete();
        return redirect()->route('user.notify.to_user')->with('success');
    }

}
