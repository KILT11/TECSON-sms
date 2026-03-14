<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function index()
    {
        return response()->json(Scholarship::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'nullable|numeric|min:0',
            'slots'       => 'required|integer|min:1',
            'deadline'    => 'nullable|date',
            'status'      => 'required|in:active,inactive,closed',
        ]);

        $scholarship = Scholarship::create($validated);

        return response()->json([
            'message' => 'Scholarship created successfully.',
            'data'    => $scholarship
        ], 201);
    }

    public function show(string $id)
    {
        $scholarship = Scholarship::find($id);

        if (!$scholarship) {
            return response()->json(['message' => 'Scholarship not found.'], 404);
        }

        return response()->json($scholarship);
    }

    public function update(Request $request, string $id)
    {
        $scholarship = Scholarship::find($id);

        if (!$scholarship) {
            return response()->json(['message' => 'Scholarship not found.'], 404);
        }

        $validated = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'amount'      => 'nullable|numeric|min:0',
            'slots'       => 'sometimes|integer|min:1',
            'deadline'    => 'nullable|date',
            'status'      => 'sometimes|in:active,inactive,closed',
        ]);

        $scholarship->update($validated);

        return response()->json([
            'message' => 'Scholarship updated successfully.',
            'data'    => $scholarship
        ]);
    }

    public function destroy(string $id)
    {
        $scholarship = Scholarship::find($id);

        if (!$scholarship) {
            return response()->json(['message' => 'Scholarship not found.'], 404);
        }

        $scholarship->delete();

        return response()->json(['message' => 'Scholarship deleted successfully.']);
    }
}