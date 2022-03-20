<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }

    public function editStudents($id)
    {
        $student = Student::find($id);
        if($student) {
            return response()->json(['status' => 200, 'student' => $student]);
        }

        return response()->json(['status' => 404, 'message' => 'Student Not Found']);
    }

    public function updateStudents(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $student = Student::find($id);



        if($student) {
           
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            $student->update();

            return response()->json(['status' => 200, 'message' => 'Student Updated Successfully']);

        } else {

            return response()->json(['status' => 404, 'message' => 'Student Not Found']);
        }
        
    }

    public function fetchStudents()
    {
        $students = DB::table('students')->orderBy('id', 'desc')->get();
        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }

        $student = new Student;
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');
        $student->course = $request->input('course');
        $student->save();

        return response()->json(['status' => 200, 'message' => 'Student Added Successfully']);
    }

}
