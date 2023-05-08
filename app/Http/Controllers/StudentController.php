<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Rating;

class StudentController extends Controller
{
    public function save_student(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $validator = Validator::make($data, [
            'name'          =>  'required',
            'email'         =>  'required | email',
            'phone'         =>  'required  '
        ]);
        if ($validator->fails()) {
            echo json_encode($validator->errors());
        } else {
            $student = new Student;

            // $file_name = time() . '_' . $request->file->getClientOriginalName();
            // $file_path = $request->file('file')->move(public_path('storage/students'), $file_name, 'public');

            // $student->names = time() . '_' . $request->file->getClientOriginalName();
            // $student->path  = '/storage/' . $file_path;
            // $student->save();
            $student->name  = request()->name;
            $student->email = request()->email;
            $student->phone = request()->phone;
            $student->names = request()->names;
            $student->path  = request()->path;
            $student->save();
            return 'ok';
        }
    }

    public function all_students()
    {
        $student = Student::paginate(5);
        return response()->json($student);
    }

    public function edit_Students($id)
    {
        $student = Student::find($id);
        return response()->json($student);
    }

    public function update_Student()
    {
        // dd(request()->id);
        $student = Student::find(request()->id);
        $student->name  = request()->name;
        $student->email = request()->email;
        $student->phone = request()->phone;
        $student->update();
        return "Student  update successfully";
    }

    public function deleteStudent($id)
    {
        $student = Student::find($id)->delete();
        return "Student has been deleted.";
    }

    public function upload(Request $request)
    {
        // dd("nikhil");
        // return "nikhilyogi";die;
        // dd($request->toArray());
        // dd($request->file());
        // $request->validate([
        //     'file' => 'required | mimes:jpg,'
        // ]);

        $student = new Student();

        if ($request->file()) {
            // dd("dfsf");
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->move(public_path('storage/students'), $file_name, 'public');
            // dd($file_path);

            $student->names = time() . '_' . $request->file->getClientOriginalName();
            $student->path  = '/storage/' . $file_path;
            $student->name  = request()->name;
            $student->email = request()->email;
            $dd = $student->phone = request()->phone;
            // dd($dd);
            $student->save();
            // dd("dsf");
            // return response()->json('file uploaded successfully.');
            return redirect('/home')->with('status', 'Student added successfully!');


            return "file uploaded successfully.";
        }
    }

    public function submitRating(Request $request)
    {       
        $rating1 = Student::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'rating' => $request->rating
            ]
        );
        return response()->json([
            'success' => true,
            'message' => 'Rating saved successfully.',
            // 'ratings' => $ratings
        ]);
    }
}
