<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'email'          => 'required|email|unique:students,email',
            'contact_number' => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'birthdate'      => 'nullable|date',
            'gender'         => 'nullable|in:Male,Female,Other',
            'school'         => 'nullable|string|max:255',
            'course'         => 'nullable|string|max:255',
            'year_level'     => 'nullable|string|max:20',
            'gwa'            => 'nullable|numeric|min:1|max:5',
            'family_income'  => 'nullable|numeric|min:0',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'Student created successfully.',
            'data'    => $student
        ], 201);
    }

    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found.'], 404);
        }

        return response()->json($student);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found.'], 404);
        }

        $validated = $request->validate([
            'first_name'     => 'sometimes|string|max:100',
            'last_name'      => 'sometimes|string|max:100',
            'middle_name'    => 'nullable|string|max:100',
            'email'          => 'sometimes|email|unique:students,email,' . $id,
            'contact_number' => 'nullable|string|max:20',
            'address'        => 'nullable|string',
            'birthdate'      => 'nullable|date',
            'gender'         => 'nullable|in:Male,Female,Other',
            'school'         => 'nullable|string|max:255',
            'course'         => 'nullable|string|max:255',
            'year_level'     => 'nullable|string|max:20',
            'gwa'            => 'nullable|numeric|min:1|max:5',
            'family_income'  => 'nullable|numeric|min:0',
        ]);

        $student->update($validated);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data'    => $student
        ]);
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found.'], 404);
        }

        $student->delete();

        return response()->json(['message' => 'Student deleted successfully.']);
    }
}
