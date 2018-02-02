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

Route::get('/', 'Auth\LoginController@get_login_page');

//Authentication routes
Auth::routes();
Route::post('/SecurityQuestions', 'Auth\ForgotPasswordController@getSecurityQuestions');
Route::post('/ResetPassword', 'Auth\ResetPasswordController@resetUserPassword');
Route::post('/ChangePassword', 'Auth\ResetPasswordController@changePassword');
Route::get('/User/{id}/EditProfile', 'UsersController@getEditProfile')->name('EditProfile');
Route::post('EditProfile', 'UsersController@postEditProfile');

//Admin Routes
//Landing page for Admin
Route::get('/home', 'AdminController@index')->name('home');

//Add Student emails
Route::get('/AddStudentEmails', 'AdminController@getStudentEmails');
Route::post('AddStudentEmails', 'AdminController@postStudentEmails');
Route::get('AddMoreStudentEmails', 'AdminController@addStudentEmails');
Route::get('RemoveStudentEmails', 'AdminController@removeStudentEmails');

//Add Instructor emails
Route::get('/AddInstructorEmails', 'AdminController@getInstructorEmails');
Route::post('AddInstructorEmails', 'AdminController@postInstructorEmails');
Route::get('AddMoreInstructorEmails', 'AdminController@addInstructorEmails');
Route::get('RemoveInstructorEmails', 'AdminController@removeInstructorEmails');

//Admin can manage emails
Route::get('/RemoveEmails', 'AdminController@get_remove_emails')->name('RemoveEmails');

//Admin can delete a email from remove email page.
Route::any('deleteuser/{id}', 'AdminController@delete_email')->name('deleteuser');
Route::any('archive/{id}', 'AdminController@archive_user')->name('archiveuser');

//Admin module management
Route::get('/ConfigureModules','AdminController@getConfigureModules');
Route::post('submitmodule', 'AdminController@submitmodule')->name('submitmodule');
Route::post('deletemodule/{modid}', 'AdminController@deletemodule')->name('deletemodule');

//Student routes
//Landing page for Student
Route::get('/StudentHome', 'StudentController@index')->name('student.home');
Route::get('/PatientView/{patient_id}', 'StudentController@view_patient')->name('patient.view');
Route::get('/PatientPreview/{patient_id}', 'NavigationController@get_preview')->name('patient_preview');
Route::get('/Patient_pdf/{patient_id}', 'NavigationController@generate_pdf')->name('pdf_generate');
Route::get('/PatientDelete/{id}', 'StudentController@destroy')->name('patient.destroy');

//Patient routes
//Add new patient
Route::get('/add_patient', 'StudentController@get_add_patient');
Route::post('add_patient', 'StudentController@post_add_patient');

//Active record routes
Route::get('/Demographics/{id}', 'NavigationController@get_demographics_panel')->name('Demographics');
Route::post('Demographics', 'DocumentationController@post_Demographics');

Route::get('/HPI/{id}', 'NavigationController@get_HPI')->name('History of Present Illness (HPI)');
Route::post('HPI', 'DocumentationController@post_HPI')->name('post_HPI');

Route::get('/Medical_History/{id}', 'NavigationController@get_medical_history')->name('Medical History');
Route::get('/Medical_History/{id}/#personal_history')->name('Personal History (PMHx)2');
Route::get('/Medical_History/{id}/#family_history')->name('Family History (FMHx)2');
Route::get('/Medical_History/{id}/#social_history')->name('Social History (SHx)2');
Route::get('/Medical_History/{id}/#surgical_history')->name('Surgical History2');

Route::post('social_history}', 'DocumentationController@post_social_history')->name('social_history');
Route::post('family_history}', 'DocumentationController@post_family_history')->name('family_history');
Route::get('/family_history', 'DocumentationController@post_new_family_member')->name('post_new_family_member');
Route::post('personal_history}', 'DocumentationController@post_personal_history')->name('personal_history');
Route::post('surgical_history}', 'DocumentationController@post_surgical_history')->name('surgical_history');

Route::any('personal_history_delete/{id}', 'DocumentationController@delete_personal_history')->name('delete_personal_history');
Route::any('family_history_delete/{id}', 'DocumentationController@delete_family_history')->name('delete_family_history');
Route::any('surgical_history_delete/{id}', 'DocumentationController@delete_surgical_history')->name('delete_surgical_history');


Route::get('/Medications/{id}', 'NavigationController@get_medications')->name('Medications');
Route::post('post_medications}', 'DocumentationController@post_medications')->name('post_medications');
Route::any('medication_delete/{id}', 'DocumentationController@delete_medication')->name('delete_medication');

Route::get('/Vital_Signs/{id}', 'NavigationController@get_vital_signs')->name('Vital Signs');
Route::post('post_vital_signs', 'DocumentationController@post_vital_signs');
Route::post('delete_vital_signs/{ts}', 'DocumentationController@delete_vital_signs')->name('delete_vital_signs');

Route::get('/Review_of_System (ROS)/{id}', 'NavigationController@get_ROS')->name('Review of System (ROS)');
Route::get('/Review_of_System (ROS)/{id}/#constitutional')->name('Constitutional9');
Route::get('/Review_of_System (ROS)/{id}/#hent')->name('HENT9');
Route::get('/Review_of_System (ROS)/{id}/#eyes')->name('Eyes9');
Route::get('/Review_of_System (ROS)/{id}/#respiratory')->name('Respiratory9');
Route::get('/Review_of_System (ROS)/{id}/#cardiovascular')->name('Cardiovascular9');
Route::get('/Review_of_System (ROS)/{id}/#musculoskeletal')->name('Musculoskeletal9');
Route::get('/Review_of_System (ROS)/{id}/#integumentary')->name('Integumentary9');
Route::get('/Review_of_System (ROS)/{id}/#neurological')->name('Neurological9');
Route::get('/Review_of_System (ROS)/{id}/#psychological')->name('Psychological9');
Route::get('/Review_of_System (ROS)/{id}/#gastrointestinal')->name('Gastrointestinal9');

Route::post('ros_constitutional', 'DocumentationController@post_ros_constitutional')->name('ros_constitutional');
Route::post('ros_hent', 'DocumentationController@post_ros_hent')->name('ros_hent');
Route::post('ros_eyes', 'DocumentationController@post_ros_eyes')->name('ros_eyes');
Route::post('ros_respiratory', 'DocumentationController@post_ros_respiratory')->name('ros_respiratory');
Route::post('ros_cardiovascular', 'DocumentationController@post_ros_cardiovascular')->name('ros_cardiovascular');
Route::post('ros_musculoskeletal', 'DocumentationController@post_ros_musculoskeletal')->name('ros_musculoskeletal');
Route::post('ros_integumentary', 'DocumentationController@post_ros_integumentary')->name('ros_integumentary');
Route::post('ros_neurological', 'DocumentationController@post_ros_neurological')->name('ros_neurological');
Route::post('ros_psychological', 'DocumentationController@post_ros_psychological')->name('ros_psychological');
Route::post('ros_gastrointestinal', 'DocumentationController@post_ros_gastrointestinal')->name('ros_gastrointestinal');


Route::get('/Physical_Exam/{id}', 'NavigationController@get_physical_exams')->name('Physical Exam');
Route::get('/Physical_Exam/{id}/#constitutional')->name('Constitutional20');
Route::get('/Physical_Exam/{id}/#hent')->name('HENT20');
Route::get('/Physical_Exam/{id}/#eyes')->name('Eyes20');
Route::get('/Physical_Exam/{id}/#respiratory')->name('Respiratory20');
Route::get('/Physical_Exam/{id}/#cardiovascular')->name('Cardiovascular20');
Route::get('/Physical_Exam/{id}/#musculoskeletal')->name('Musculoskeletal20');
Route::get('/Physical_Exam/{id}/#integumentary')->name('Integumentary20');
Route::get('/Physical_Exam/{id}/#neurological')->name('Neurological20');
Route::get('/Physical_Exam/{id}/#psychological')->name('Psychological20');
Route::get('/Physical_Exam/{id}/#gastrointestinal')->name('Gastrointestinal20');

Route::post('Gastrointestinal', 'DocumentationController@post_gastrointestinal')->name('Gastrointestinal');
Route::post('Psychological', 'DocumentationController@post_psychological')->name('Psychological');
Route::post('Neurological', 'DocumentationController@post_neurological')->name('Neurological');
Route::post('Integumentary', 'DocumentationController@post_integumentary')->name('Integumentary');
Route::post('Musculoskeletal', 'DocumentationController@post_musculoskeletal')->name('Musculoskeletal');
Route::post('Cardiovascular', 'DocumentationController@post_cardiovascular')->name('Cardiovascular');
Route::post('Respiratory', 'DocumentationController@post_respiratory')->name('Respiratory');
Route::post('Eyes', 'DocumentationController@post_eyes')->name('Eyes');
Route::post('HENT', 'DocumentationController@post_HENT')->name('HENT');
Route::post('Constitutional', 'DocumentationController@post_Constitutional')->name('Constitutional');

Route::get('/Orders/{id}', 'NavigationController@get_orders')->name('Orders');
Route::post('post_orders}', 'DocumentationController@post_orders')->name('post_orders');
Route::post('orders_delete/{id}', 'DocumentationController@delete_image_order')->name('delete_image_order');
Route::any('orders_lab_delete/{id}', 'DocumentationController@delete_lab_order')->name('delete_lab_order');
Route::any('orders_image_delete/{id}', 'DocumentationController@delete_image_order')->name('delete_image_order');
Route::any('orders_lab_delete/{id}', 'DocumentationController@delete_lab_order')->name('delete_lab_order');

Route::get('/Results/{id}', 'NavigationController@get_results')->name('Results');
Route::post('post_results}', 'DocumentationController@post_results')->name('post_results');

Route::get('/MDM/{id}', 'NavigationController@get_MDM')->name('MDM/Plan');
Route::post('MDM','DocumentationController@post_MDM')->name('post_MDM');

Route::get('/Disposition/{id}', 'NavigationController@get_disposition')->name('Disposition');
Route::post('disposition', 'DocumentationController@post_disposition')->name('post_disposition');

Route::get('/{id}/AssignInstructor', 'NavigationController@get_assignInstructor')->name('AssignInstructor');
Route::post('InstructorAssigned', 'DocumentationController@post_assignInstructor')->name('InstructorAssigned');

//Landing page for Instructor
Route::get('/InstructorHome', 'InstructorController@index')->name('instructor.home');
Route::get('/{id}/InstructorHome', 'InstructorController@review_patient')->name('patient.reviewed');

//Routes for autocomplete
Route::get('/diagnosis/find', 'DocumentationController@find_diagnosis')->name('diagnosis_find');
Route::get('/medications/find', 'DocumentationController@find_medications')->name('medications_find');
Route::get('/orders_labs/find', 'DocumentationController@find_lab_orders')->name('orders_labs_find');
Route::get('/orders_imaging/find', 'DocumentationController@find_imaging_orders')->name('orders_imaging_find');
Route::get('/instructors/find', 'DocumentationController@find_instructor')->name('instructors_find');

Route::get('/account_deleted', function () {
    return view('errors/account_deleted');
});



