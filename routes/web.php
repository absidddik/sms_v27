<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });



// Authentication Routes...
$this->get('', 'Auth\LoginController@showLoginForm')->name('login');
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// student login
$this->get('student/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
$this->post('student/login', 'Auth\StudentLoginController@login')->name('student.login.submit');

// Registration Routes...
// $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// $this->post('register', 'Auth\RegisterController@register');


//.........ADMIN AREA..........
//........admin login
Route::get('admin/login','Admin\User\AdminUsersController@login')->name('admin.login');

Route::group(['prefix'=>'admin'],function(){
    //..........admin dash
    Route::get('dash','Admin\Dash\AdminDashController@dash')->name('admin.dash');
    //..........user role
    Route::resource('user-role','Admin\Role\UserRolesController',['except'=>['create','show']]);
    //..........user
    Route::resource('users','Admin\User\AdminUsersController',['except'=>'show']);
    Route::put('users/password/{id}','Admin\User\AdminUsersController@changePassword')->name('user.changePassword');
    Route::get('users/verify/{token}','Admin\User\AdminUsersController@verifyByAdmin')->name('user.verifyByAdmin');
    Route::get('users/admin/{id}','Admin\User\AdminUsersController@makeAdmin')->name('user.makeAdmin');
    Route::get('users/regular/{id}','Admin\User\AdminUsersController@makeRegular')->name('user.makeRegular');
    Route::get('users/active/{id}','Admin\User\AdminUsersController@active')->name('user.active');
    Route::get('users/deactive/{id}','Admin\User\AdminUsersController@deactive')->name('user.deactive');

    //.........batch
    Route::resource('batch','Admin\Batch\BatchesController',['except'=>'show']);
    //.........exam-time
    Route::resource('exam-time','Admin\ExamTime\ExamTimesController',['except'=>'show']);
    //.........student
    Route::resource('student', 'Admin\Student\StudentsController');
    //.........semester
    Route::resource('semester','Admin\Semester\SemestersController',['except'=>['create','show']]);
    //.........subject
    Route::resource('course','Admin\Course\CoursesController',['except'=>'show']);
    //.........teacher
    Route::get('teacher','Admin\Teacher\TeachersController@index')->name('teacher.index');

    //.........subject enroll
    Route::resource('course-enroll','Admin\CourseEnroll\CourseEnrollController',['except'=>['show']]);
    Route::get('course-enroll/show','Admin\CourseEnroll\CourseEnrollController@show')->name('course-enroll.show');

    //.........Batch enroll
    Route::resource('batch-enroll','Admin\batchEnroll\BatchEnrollsController',['except'=>['show']]);
    Route::get('batch-enroll/show','Admin\batchEnroll\BatchEnrollsController@show')->name('batch-enroll.show');

    //.........student enroll
    Route::resource('student-enroll','Admin\StudentEnroll\StudentEnrollsController');
    Route::get('student-enrolls/show','Admin\StudentEnroll\StudentEnrollsController@enrolls_show')->name('student-enrolls.show');
    Route::get('student-enrolls/get_data','Admin\StudentEnroll\StudentEnrollsController@get_data_by_json_where_semester_id')->name('student-enrolls.get_data');
    Route::get('student-enrolls/unroll','Admin\StudentEnroll\StudentEnrollsController@student_unroll')->name('student-enrolls.unroll');


    //.........Due student enroll
    Route::resource('due-student-enroll','Admin\DueEnroll\DueEnrollController');
    Route::get('due/student-enrolls/show','Admin\DueEnroll\DueEnrollController@enrolls_show')->name('due.student-enrolls.show');
    Route::get('due/student-enrolls/get_data','Admin\DueEnroll\DueEnrollController@get_data_by_json_where_semester_id')->name('due.student-enrolls.get_data');
    Route::get('due/student-enrolls/unroll','Admin\DueEnroll\DueEnrollController@student_unroll')->name('due.student-enrolls.unroll');


    // .........supplementary enroll
    Route::resource('supplementary-enroll'      ,'Admin\SupplementaryEnroll\SuppEnrollController');
    Route::get('supplementary-enrolls/show'     ,'Admin\SupplementaryEnroll\SuppEnrollController@enrolls_show')->name('supplementary-enrolls.show');
    Route::get('supplementary-enrolls/get_data' ,'Admin\SupplementaryEnroll\SuppEnrollController@get_data_by_json_where_course_e_id')->name('supplementary-enrolls.get_data');
    Route::get('supplementary-enrolls/unroll'   ,'Admin\SupplementaryEnroll\SuppEnrollController@supp_unroll')->name('supplementary-enrolls.unroll');

    //.........external subject enroll
   Route::resource('external-enroll','Admin\ExternalEnroll\ExternalEnrollsController',['except'=>['show']]);
   Route::get('external-enroll/show','Admin\ExternalEnroll\ExternalEnrollsController@show')->name('external-enroll.show');

   //.........charman enroll
   Route::resource('charman-enroll','Admin\CharmanEnroll\CharmanEnrollsController',['except'=>'show']);
   Route::get('charman-enroll/show','Admin\CharmanEnroll\CharmanEnrollsController@show')->name('charman-enroll.show');


});

//.........user common features
Route::group(['prefix'=>'user'],function(){
    //........dashboard
    Route::get('/dash', 'User\Dash\UserDashController@dash')->name('user.dash');
    //........user profile
    Route::get('profile/{user_id}','User\Profile\ProfilesController@show')->name('profile.show');
    //........user account
    Route::get('account/setting/{user_id}','User\Account\AccountsController@setting')->name('account.setting');
    Route::put('account/setting/{user_id}','User\Account\AccountsController@update')->name('account.update');
    Route::put('account/password/{user_id}','User\Account\AccountsController@changePassword')->name('account.changePassword');
    //........user personal info
    Route::get('personal-info/{user_id}','User\PersonalInfo\PersonalInfosController@edit')->name('personal-info.edit');
    Route::post('personal-info/{user_id}','User\PersonalInfo\PersonalInfosController@update')->name('personal-info.update');
    Route::get('personal-info/profile-pic/{user_id}','User\PersonalInfo\PersonalInfosController@profilePic')->name('personal-info.profile-pic.edit');
    Route::post('personal-info/profile-pic/{user_id}','User\PersonalInfo\PersonalInfosController@uploadProfilePic')->name('personal-info.profile-pic.upload');
});

//.........TEACHER
Route::group(['prefix'=>'teacher'],function(){

    //..............teacher semester course
    Route::get('semester-course', 'Teacher\SemesterCoursesController@index')->name('semester-course');
    Route::get('semester-course/{course_e_id}/{semester_id}', 'Teacher\SemesterCoursesController@show')->name('semester-course.show');

    //..............teacher supplementary course
    Route::get('supplementary-course', 'Teacher\Supplementary\SupplementaryController@index')->name('supplementary-course');

    //...........view supplementary mark
    Route::get('supplementary-mark/{supp_e_id}/{student_id}', 'Teacher\Supplementary\SupplementaryController@edit')->name('supplementary-mark.edit');
    Route::post('supplementary-mark/store', 'Teacher\Supplementary\SupplementaryController@store')->name('supplementary-mark.store');
    Route::put('supplementary-mark/{id}', 'Teacher\Supplementary\SupplementaryController@update')->name('supplementary-mark.update');

    //...........view supplementary student list
    Route::get('result-supplementary-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@suppSeventyShow')->name('result.supp.show');

    //...........view supp viva voce student list
    Route::get('supp/result-viva-voce-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@suppVivaShow')->name('internal.supp-result.viva-voce.show');

    //...........view supp lab student list
    Route::get('supp/result-lab-mark-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@suppLabShow')->name('internal.supp-result.lab-mark.show');

    //...........view viva voce student list
    Route::get('result-viva-voce-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@vivaShow')->name('internal.result.viva-voce.show');

    //...........view lab student list
    Route::get('result-lab-mark-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@labMarkShow')->name('internal.result.lab-mark.show');

    //...........view 30% student list
    Route::get('result-thirty-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@thirtyShow')->name('internal.result.thirty.show');
    //...........view 70% student list
    Route::get('result-seventy-show/{course_e_id}/{semester_id}', 'Teacher\Internal\ResultViewController@seventyShow')->name('internal.result.seventy.show');

    // ThirtyPercentMarkController
    Route::get('internal/thirty-percetn-mark/{course_e_id}/{student_id}', 'Teacher\Internal\ThirtyPercentMarkController@edit')->name('internal.thirty-percetn-mark.edit');
    Route::post('internal/thirty-percetn-mark/store', 'Teacher\Internal\ThirtyPercentMarkController@store')->name('internal.thirty-percetn-mark.store');
    Route::put('internal/thirty-percetn-mark/{id}', 'Teacher\Internal\ThirtyPercentMarkController@update')->name('internal.thirty-percetn-mark.update');


    // SeventyPercentMarkController
    Route::get('internal/seventy-percetn-mark/{course_e_id}/{student_id}', 'Teacher\Internal\SeventyPercentMarkController@edit')->name('internal.seventy-percetn-mark.edit');
    Route::post('internal/seventy-percetn-mark/store', 'Teacher\Internal\SeventyPercentMarkController@store')->name('internal.seventy-percetn-mark.store');
    Route::put('internal/seventy-percetn-mark/{id}', 'Teacher\Internal\SeventyPercentMarkController@update')->name('internal.seventy-percetn-mark.update');

    // VivaVoceController
    Route::get('internal/viva-voce-mark/{course_e_id}/{student_id}', 'Teacher\Internal\VivaVoceMarkController@edit')->name('internal.viva-voce-mark.edit');
    Route::post('internal/viva-voce-mark/store', 'Teacher\Internal\VivaVoceMarkController@store')->name('internal.viva-voce-mark.store');
    Route::put('internal/viva-voce-mark/{id}', 'Teacher\Internal\VivaVoceMarkController@update')->name('internal.viva-voce-mark.update');

    // LabMarkController
    Route::get('internal/lab-mark/{course_e_id}/{student_id}', 'Teacher\Internal\LabMarkController@edit')->name('internal.lab-mark.edit');
    Route::post('internal/lab-mark/store', 'Teacher\Internal\LabMarkController@store')->name('internal.lab-mark.store');
    Route::put('internal/lab-mark/{id}', 'Teacher\Internal\LabMarkController@update')->name('internal.lab-mark.update');


    // SuppVivaVoceController
    Route::get('internal/supp/viva-voce-mark/{supp_e_id}/{student_id}', 'Teacher\Supplementary\VivaVoceMarkController@edit')->name('internal.supp-viva-voce-mark.edit');
    Route::post('internal/supp/viva-voce-mark/store', 'Teacher\Supplementary\VivaVoceMarkController@store')->name('internal.supp-viva-voce-mark.store');
    Route::put('internal/supp/viva-voce-mark/{id}', 'Teacher\Supplementary\VivaVoceMarkController@update')->name('internal.supp-viva-voce-mark.update');

    // SuppLabMarkController
    Route::get('internal/supp/lab-mark/{supp_e_id}/{student_id}', 'Teacher\Supplementary\LabMarkController@edit')->name('internal.supp-lab-mark.edit');
    Route::post('internal/supp/lab-mark/store', 'Teacher\Supplementary\LabMarkController@store')->name('internal.supp-lab-mark.store');
    Route::put('internal/supp/lab-mark/{id}', 'Teacher\Supplementary\LabMarkController@update')->name('internal.supp-lab-mark.update');



    //............Full marks
    Route::get('internal/full-marks/{e_id}/{c_id}/{s_id}', 'Teacher\Internal\FullMarksController@index')->name('internal.full-marks.index');

    //.............EXTERNAL
    //............semester course
    Route::get('external-course', 'Teacher\External\ExternalSemesterCoursesController@index')->name('external-course');
    Route::get('external-course/{course_e_id}/{semester_id}', 'Teacher\External\ExternalSemesterCoursesController@show')->name('external-course.show');

    //...........view 70% student list
    Route::get('external/result-seventy-show/{course_e_id}/{semester_id}', 'Teacher\External\ResultViewController@seventyShow')->name('external.result.seventy.show');

    // SeventyPercentMarkController
    Route::get('external/seventy-percetn-mark/{course_e_id}/{student_id}', 'Teacher\External\SeventyPercentMarkController@edit')->name('external.seventy-percetn-mark.edit');
    Route::post('external/seventy-percetn-mark/store', 'Teacher\External\SeventyPercentMarkController@store')->name('external.seventy-percetn-mark.store');
    Route::put('external/seventy-percetn-mark/{id}', 'Teacher\External\SeventyPercentMarkController@update')->name('external.seventy-percetn-mark.update');
    //............full marks
    Route::get('external/full-marks/{e_id}/{c_id}/{s_id}', 'Teacher\External\FullMarksController@index')->name('external.full-marks.index');

    //...........submit result
    Route::post('submit','Result\Submit\SubmitController@submit')->name('result.submit');

    // PDF
    Route::get('pdf/internal/thirty-percetn-mark/{e_id}/{c_id}/{s_id}','Teacher\PDF\PDFController@thirty_percent_mark')->name('pdf.thirty-percetn-mark');
    Route::get('pdf/internal/seventy-percetn-mark/{ce_id}','Teacher\PDF\PDFController@internal_seventy_percent_mark')->name('pdf.internal-seventy-percetn-mark');

    //............test 30%
    // Route::resource('tharty-mark','Teacher\Internal\TestController');

});

//.........CHARMAN
Route::group(['prefix'=>'chairman'],function(){

    Route::get('chairman-result','Charman\ResultsController@index')->name('charman-result.index');
    Route::get('chairman-result-show/{exam_id}/{semester_id}','Charman\ResultsController@show')->name('charman-result.show');
    Route::get('chairman-result-with-mark-full/{exam_id}/{semester_id}','Charman\ResultsController@showFullMark')->name('charman-result-full-mark.show');
    Route::get('chairman-result-with-mark/{exam_id}/{semester_id}','Charman\ResultsController@showWithMark')->name('charman-result-with-mark.show');
    Route::get('chairman-result-without-mark/{exam_id}/{semester_id}','Charman\ResultsController@showWithoutMark')->name('charman-result-without-mark.show');


    // PDF
    Route::get('pdf/charman-result-full-mark/{exam_id}/{semester_id}','Charman\PDF\ResultsController@showFullMark')->name('pdf.charman-result-full-mark.show');
    Route::get('pdf/charman-result-with-mark/{exam_id}/{semester_id}','Charman\PDF\ResultsController@showWithMark')->name('pdf.charman-result-with-mark.show');
    Route::get('pdf/charman-result-without-mark/{exam_id}/{semester_id}','Charman\PDF\ResultsController@showWithoutMark')->name('pdf.charman-result-without-mark.show');


    // Third Examiner
    Route::get('third-examiner','Charman\ThirdExaminersController@index')->name('third-examiner.index');
    Route::get('third-examiner/course-details/{c_id}/{s_id}/{et_id}','Charman\ThirdExaminersController@course_details')->name('third-examiner.course-details');

    // Third Examiner Mark
    Route::get('third-examiner/seventy-percetn-mark/{course_e_id}/{student_id}', 'Teacher\Third_Ex\SeventyPercentMarkController@edit')->name('third-examiner.seventy-percetn-mark.edit');
    Route::post('third-examiner/seventy-percetn-mark/store', 'Teacher\Third_Ex\SeventyPercentMarkController@store')->name('third-examiner.seventy-percetn-mark.store');
    Route::put('third-examiner/seventy-percetn-mark/{id}', 'Teacher\Third_Ex\SeventyPercentMarkController@update')->name('third-examiner.seventy-percetn-mark.update');

});

//.........Student
Route::group(['prefix'=>'student'],function(){

    Route::get('/dash','Student\Dash\StudentDashController@index')->name('student.dash');

});
