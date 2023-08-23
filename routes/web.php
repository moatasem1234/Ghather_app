<?php

use App\Http\Controllers\Admin\AnswersController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\User\AssignmentCourseController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TestCourseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\RoutineXIController;
use App\Http\Controllers\Admin\RoutineXIIController;
use App\Http\Controllers\User\NoticeViewController;

use App\Http\Controllers\User\Posts\PostsController;
use App\Http\Controllers\User\Posts\LikesController;
use App\Http\Controllers\User\Posts\CommentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => 'auth', 'middleware' => 'verified'], function() {
    //__Home routes
    Route::get('/home', [UserController::class, 'index'])->name('home');

    Route::get('/User_test', [\App\Http\Controllers\User\TestCourseController::class, 'index'])->name('User_test');
    Route::resource('User_course', \App\Http\Controllers\User\UserCourseController::class);
    Route::post('/User_lesson', [\App\Http\Controllers\User\UserLessonController::class, 'index'])->name('User_lesson.index');
    Route::post('lesson/{slug}/test', [App\Http\Controllers\User\UserLessonController::class, 'test'])->name('lessons.test');


    Route::post('/User_test', [\App\Http\Controllers\User\TestCourseController::class, 'index'])->name('User_test.index');
    Route::post('/User_test/question', [\App\Http\Controllers\User\TestCourseController::class, 'show'])->name('User_test.question.show');
    Route::post('/User_test/result', [\App\Http\Controllers\User\TestCourseController::class, 'submitAnswers'])->name('User_test.result');


    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/user/notification',[\App\Http\Controllers\NotificationsController::class,'to_user'])->name('user.notify.to_user');
    Route::post('/user/notification/update',[\App\Http\Controllers\NotificationsController::class,'update'])->name('user.notify.update');
    Route::post('/user/notification/destroy}',[\App\Http\Controllers\NotificationsController::class,'destroy'])->name('user.notify.destroy');



    Route::post('/assignments', [AssignmentCourseController::class, 'index'])->name('user.assignments.index');
    Route::get('/assignments/{id}/answer', [AssignmentCourseController::class, 'answer'])->name('user.assignments.answer');
    Route::post('/assignments/submit', [AssignmentCourseController::class, 'submitAnswers'])->name('user.assignments.submit');

 //__Change password
    Route::post('/user_password/update', [NewPasswordController::class, 'password_update'])->name('user_password.update');

    //__User profile routes
    Route::get('profile/{id}', [UserController::class, 'profile'])->name('user.profile');

    //__Notice routes
    Route::get('/notice', [NoticeViewController::class, 'index'])->name('notice.view');

    //__Post routes
    Route::resource('/posts', PostsController::class);
    Route::resource('/posts/like', LikesController::class);
    Route::resource('/posts/comment', CommentsController::class);

    //__Videos route
    Route::get('/videos', [UserController::class, 'videos'])->name('videos');


    Route::get('/teacher_student_info', [UserController::class, 'teacher_student_view'])->name('teacher_student_info');

    Route::get('/chat',function (){
        return view('user.chat');
    })->name('user.chat');


});


// __Admission routes
Route::get('/admission/procedure', function () {
    return view('admission.admission_procedure');
})->name('admission.procedure');

Route::post('/student/admission/store', [AdmissionController::class, 'store'])->name('student.admission.store');
Route::post('/student/admission/verify', [AdmissionController::class, 'verify'])->name('student.admission.verify');


require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login')->middleware('guest:admin');
Route::post('/admin/login/store', [AuthenticatedSessionController::class, 'store'])->name('admin.login.store');

Route::group(['middleware' => 'admin'], function() {

    Route::get('/admin', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

    Route::prefix('admin')->group(function () {
        Route::get('/assignments', [AssignmentController::class, 'index'])->name('admin.assignments.index');
    });
    Route::get('/admin/assignments/create', [AssignmentController::class, 'create'])->name('admin.assignments.create');
    Route::post('/admin/assignments', [AssignmentController::class, 'store'])->name('admin.assignments.store');


    Route::get('answers', [AnswersController::class, 'index'])->name('admin.answers.index');
    Route::get('answers/{courseId}/assignments', [AnswersController::class, 'showAssignments'])->name('admin.answers.assignments');
    Route::get('answers/{assignmentId}', [AnswersController::class, 'showAnswers'])->name('admin.answers.answers');
    Route::patch('answers/{assignmentId}', [AnswersController::class, 'update'])->name('answers.update');



    Route::get('/admin/password/change', [HomeController::class, 'password_change'])->name('admin.password.change');
    Route::post('/admin/password/update', [HomeController::class, 'password_update'])->name('admin.password.update');

    // __Notice routes
    Route::resource('/admin/notice', NoticeController::class);
    Route::post('/process-excel', [\App\Http\Controllers\Admin\QuestionController::class,'processUploadedExcel'])->name('process-excel');



//   ///////////////////////////////////////////////////////////////////
    Route::resource('lesson', \App\Http\Controllers\Admin\LessonController::class);
    Route::post('lessons_restore/{id}', [\App\Http\Controllers\Admin\LessonController::class,'restore'])->name('lessons.restore');

    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::delete('courses_perma_del/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'perma_del'])->name('courses.perma_del');
    Route::post('courses_restore/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'restore'])->name('courses.restore');
    Route::get('/course/{id}/students', [\App\Http\Controllers\Admin\CourseController::class, 'show_student'])->name('course.students.show');

    Route::resource('tests', \App\Http\Controllers\Admin\TestController::class);
    Route::post('tests_restore/{id}', [\App\Http\Controllers\Admin\TestController::class,'restore'])->name('tests.restore');

    Route::get('/tests/{id}/view_grades', [\App\Http\Controllers\Admin\TestController::class, 'viewGrades'])->name('tests.view_grades');
    Route::post('/tests/{id}/send_grades', [\App\Http\Controllers\Admin\TestController::class, 'sendGrades'])->name('tests.send_grades');


    Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
    Route::post('questions_restore/{id}', [\App\Http\Controllers\Admin\QuestionController::class,'restore'])->name('questions.restore');

    Route::resource('question_options', \App\Http\Controllers\Admin\QuestionOptionController::class);
    Route::post('question_options_restore/{id}', [\App\Http\Controllers\Admin\QuestionOptionController::class, 'restore'])->name('question_options.restore');
    Route::delete('question_options_perma_del/{id}', [\App\Http\Controllers\Admin\QuestionOptionController::class, 'perma_del'])->name('question_options.perma_del');
    Route::put('admin/question_options/{id}', [\App\Http\Controllers\Admin\QuestionOptionController::class,'update'])->name('admin.question_options.update');


    /////////////////////////////////////////////////
    Route::resource('cu', \App\Http\Controllers\Admin\UserCourseConcroller::class);
    Route::post('/cu/{id}', [\App\Http\Controllers\Admin\UserCourseConcroller::class, 'destroy'])->name('cu.destroy');
    Route::get('/record',function (){
        return view('admin.record.record');
    })->name('admin.record');

    Route::get('/admin/notification',[\App\Http\Controllers\NotificationsController::class,'index'])->name('admin.notify.index');
    Route::post('/admin/notification',[\App\Http\Controllers\NotificationsController::class,'store'])->name('admin.notify.store');

});

