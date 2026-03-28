<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::with('applications')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'middle_name'    => 'nullable|string',
            'email'          => 'required|email|unique:students',
            'contact_number' => 'nullable|string',
            'address'        => 'nullable|string',
            'birthdate'      => 'nullable|date',
            'gender'         => 'nullable|in:male,female,other',
            'school'         => 'nullable|string',
            'course'         => 'nullable|string',
            'year_level'     => 'nullable|integer',
            'gwa'            => 'nullable|numeric',
            'family_income'  => 'nullable|numeric',
        ]);

        $student = Student::create($data);
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::with('applications')->findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return response()->json(['message' => 'Student deleted.']);
    }
}