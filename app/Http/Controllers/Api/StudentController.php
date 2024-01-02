<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if($students->count() > 0){
            return response()->json([
                'status'=>200,
                'students'=>$students
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'students'=>"Not Found"
            ],404);

        }
        
    }


    public function store(Request $request)
    {
        $validator = validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|string|max:191',
        ]);

        if ($validator ->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->message()
            ],422);
        }else{
            $student = Student::create([
                'name'=>$request->name,
                'course'=>$request->course,
                'email'=>$request->email,
            ]);
            
            if ($student){
                return response()->json([
                    'status'=>200,
                    'message'=>"Student created succesfully"
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>"Something went wrong"
                ],500);

            }
        }
        
    }
}

