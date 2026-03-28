<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return response()->json(Application::with(['student', 'scholarship'])->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'     => 'required|exists:students,id',
            'scholarship_id' => 'required|exists:scholarships,id',
        ]);

        $data['status']       = 'pending';
        $data['submitted_at'] = now();

        return response()->json(Application::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Application::with(['student', 'scholarship'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $request->validate([
            'status'  => 'required|in:pending,approved,rejected',
            'remarks' => 'nullable|string',
        ]);

        $application->update([
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'reviewed_at' => now(),
            'reviewed_by' => $request->user()->id,
        ]);

        return response()->json($application);
    }

    public function destroy($id)
    {
        Application::findOrFail($id)->delete();
        return response()->json(['message' => 'Application deleted.']);
    }
}