<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator; 


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
                'errors'=>$validator->messages()
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


    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);

        }else{
            return response()->json([
                'status' =>404,
                'message' =>"No student found"
            ],404);

        }
    }

    public function update(Request $request , int $id){

        $validator = validator::make($request->all(),[
            'name'=>'required|string|max:191',
            'course'=>'required|string|max:191',
            'email'=>'required|string|max:191',
        ]);

        if ($validator ->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $student = Student::find($id);
          
            
            if ($student){

                $student->update([
                    'name'=>$request->name,
                    'course'=>$request->course,
                    'email'=>$request->email,
                ]);

                return response()->json([
                    'status'=>200,
                    'message'=>"Student updated succesfully"
                ],200);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>"No student found"
                ],404);

            }
        }
        
    
    }

    public function destroy($id){
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
               'message'=>"student deleted succesfully" 
            ]);
            
        }else{
            return response()->json([
                'status'=>404,
                'message'=>"No student found"
            ],404);

        }
    }
}

