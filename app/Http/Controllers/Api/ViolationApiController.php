<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Violation;
use Illuminate\Http\Request;

class ViolationApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Violation::latest()->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Violation::findOrFail($id)
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'violation_type' => 'required|string',
            'recorded_speed' => 'nullable|integer',
            'decibel_level' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $violation = Violation::create($validated);

        return response()->json([
            'message' => 'Violation saved successfully',
            'data' => $violation
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $violation = Violation::findOrFail($id);

        $validated = $request->validate([
            'plate_number' => 'required|string|max:255',
            'violation_type' => 'required|string',
            'recorded_speed' => 'nullable|integer',
            'decibel_level' => 'nullable|integer',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $violation->update($validated);

        return response()->json([
            'message' => 'Violation updated successfully',
            'data' => $violation->fresh()
        ]);
    }

    public function destroy($id)
    {
        $violation = Violation::findOrFail($id);

        $violation->delete();

        return response()->json([
            'message' => 'Violation deleted successfully'
        ]);
    }

    public function resolve($id)
    {
        $violation = Violation::findOrFail($id);

        $violation->update([
            'status' => 'Resolved'
        ]);

        return response()->json([
            'message' => 'Violation resolved successfully',
            'data' => $violation->fresh()
        ]);
    }
}