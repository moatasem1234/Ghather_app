<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // عرض صفحة البروفايل
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // تحديث الصورة
    public function update(Request $request)
    {
        $request->validate([
            'user_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // تأكد أن الحدود مطابقة لاحتياجاتك
        ]);

        // اذا تم ارسال صورة جديدة
        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $name_slug = Str::slug(Auth::user()->name, '-');
            $imageName = time() . '-' . $name_slug . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('images/users');
            $image->move($destinationPath, $imageName);

            // قم بتحديث اسم الصورة في قاعدة البيانات
            Auth::user()->update([
                'user_image' => $imageName,
            ]);
        }

        return redirect()->back()->with('success', 'Profile image updated successfully.');
    }
}

