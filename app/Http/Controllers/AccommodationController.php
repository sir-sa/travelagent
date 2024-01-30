<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccommodationController extends Controller
{
    // Create a new accommodation
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'price_per_night' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }

        $accommodation = Accommodation::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Accommodation created successfully',
            'data' => $accommodation,
        ]);
    }

    // Get all accommodations
    public function index()
    {
        $accommodations = Accommodation::orderBy('id','desc')->get();

        return response()->json([
            'status' => 200,
            'data' => $accommodations,
        ]);
    }

    // Get a specific accommodation by ID
    public function show($id)
    {
        $accommodation = Accommodation::findOrFail($id);

        if (!$accommodation) {
            return response()->json([
                'status' => 404,
                'message' => 'Accommodation not found',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $accommodation,
        ]);
    }

    // Update an accommodation
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'address' => 'string',
            'description' => 'nullable|string',
            'amenities' => 'nullable|string',
            'price_per_night' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }

        $accommodation = Accommodation::findOrFail($id);

        if (!$accommodation) {
            return response()->json([
                'status' => 404,
                'message' => 'Accommodation not found',
            ]);
        }

        $accommodation->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Accommodation updated successfully',
            'data' => $accommodation,
        ]);
    }

    // Delete an accommodation
    public function destroy($id)
    {
        $accommodation = Accommodation::find($id);

        if (!$accommodation) {
            return response()->json([
                'status' => 404,
                'message' => 'Accommodation not found',
            ]);
        }

        $accommodation->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Accommodation deleted successfully',
        ]);
    }
}
