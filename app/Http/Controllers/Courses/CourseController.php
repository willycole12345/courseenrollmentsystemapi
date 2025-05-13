<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\CourseResource;
use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;


class CourseController extends Controller
{
     public function getusers(){
        $response = array();
        $record = User::all();
         $response['status'] = "success";
        $response['message'] = $record;
          return new CourseResource($response);
    }
    public function create(LoginRequest $request){
        $response = array();

        $validation = $request->validated();
    
        $user = User::where('email', $validation['email'])->first();
    
        if (! $user || ! Hash::check($validation['password'], $user->password)) {
        $response['message'] = 'The provided credentials are incorrect';
        $response['status'] = 'failed';
        }else{
            $response['message'] = 'Login successfull';
            $response['token'] = $user->createToken($request->email)->plainTextToken;
        $response['status'] = 'success';
        }
 
    return new CourseResource($response);
    }
    public function Enrollcourses(Request $request){

        $user = $request->user();
         try{

        $courses = $user->enrolledCourses()->withCount('comments')->get();
        $response['status'] = "success";
        $response['message'] = $courses;
        
         } catch (Exception $e) {

              $response['status'] = "failed";
             $response['message'] = "Courses does not exist";
         }
        return new CourseResource($response);
    
    }

    public function courses($id,Request $request){

         $user = $request->user();
            try{
                    $getcouse = Course::whereHas('enrollments', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                    })->with(['comments' => function ($q) {
                    $q->latest()->limit(5);
                    }])->findOrFail($id);
                    
                $response['status'] = "success";
                $response['message'] = $getcouse;

            } catch (Exception $e) {

                $response['status'] = "failed";
                 $response['message'] = 'Course does not exist';

            }

        return new CourseResource($response);

    }

    public function addComment($id , CommentRequest $request){
      
        $response = array();
         $user = $request->user();
         
         $validated  = $request->validated();
         
         try{

         $course = Course::whereHas('enrollments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
           })->findOrFail($id);

            if(  $course ){
            $comment = Comment::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'message' => $validated['message'],
                    ]);

            if($comment ){
                $response['status'] = "success";
                 $response['message'] = $comment;
            }
        }
     
         } catch (Exception $e) {

                $response['status'] = "failed";
                $response['message'] = 'User not Enroll for this course';

         }

          return new CourseResource($response);
    }

    public function getComment($id,Request $request){

        $response= array();
        $user = $request->user();

        try{

         $course = Course::whereHas('enrollments', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($id);
        
        if($course){

            $comments = $course->comments()->with('user:id,name')->latest()->paginate(5);   
            $response['status'] = "success";
            $response['message'] = $comments;
        }

        } catch (Exception $e) {

            $response['status'] = "failed";
            $response['message'] = 'User not Enroll for this course';

        }
          return new CourseResource($response);
        
    }
}
