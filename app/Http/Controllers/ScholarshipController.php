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
        $data = $request->validate([
            'name'         => 'required|string',
            'description'  => 'nullable|string',
            'amount'       => 'required|numeric',
            'slots'        => 'required|integer',
            'deadline'     => 'required|date',
            'status'       => 'required|in:open,closed',
            'requirements' => 'nullable|array',
        ]);

        return response()->json(Scholarship::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Scholarship::with('applications')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($request->all());
        return response()->json($scholarship);
    }

    public function destroy($id)
    {
        Scholarship::findOrFail($id)->delete();
        return response()->json(['message' => 'Scholarship deleted.']);
    }
}