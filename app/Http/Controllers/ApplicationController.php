<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return response()->json(
            Application::with(['student', 'scholarship'])->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'     => 'required|exists:students,id',
            'scholarship_id' => 'required|exists:scholarships,id',
            'status'         => 'sometimes|in:pending,approved,rejected',
            'remarks'        => 'nullable|string',
        ]);

        $exists = Application::where('student_id', $validated['student_id'])
                              ->where('scholarship_id', $validated['scholarship_id'])
                              ->whereIn('status', ['pending', 'approved'])
                              ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Student has already applied for this scholarship.'
            ], 422);
        }

        $application = Application::create([
            'student_id'     => $validated['student_id'],
            'scholarship_id' => $validated['scholarship_id'],
            'status'         => $validated['status'] ?? 'pending',
            'remarks'        => $validated['remarks'] ?? null,
            'submitted_at'   => now(),
        ]);

        return response()->json([
            'message' => 'Application submitted successfully.',
            'data'    => $application
        ], 201);
    }

    public function show(string $id)
    {
        $application = Application::with(['student', 'scholarship'])->find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found.'], 404);
        }

        return response()->json($application);
    }

    public function update(Request $request, string $id)
    {
        $application = Application::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found.'], 404);
        }

        $validated = $request->validate([
            'status'  => 'required|in:pending,approved,rejected',
            'remarks' => 'nullable|string',
        ]);

        $application->update([
            'status'      => $validated['status'],
            'remarks'     => $validated['remarks'] ?? $application->remarks,
            'reviewed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Application updated successfully.',
            'data'    => $application
        ]);
    }

    public function destroy(string $id)
    {
        $application = Application::find($id);

        if (!$application) {
            return response()->json(['message' => 'Application not found.'], 404);
        }

        $application->delete();

        return response()->json(['message' => 'Application deleted successfully.']);
    }
}