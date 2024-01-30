<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    // Create a new contract
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'accommodation_id' => 'required|exists:accommodations,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'rate' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }

        $contract = Contract::create($request->all());

        return response()->json([
            'status' => 201,
            'message' => 'Contract created successfully',
            'data' => $contract,
        ]);
    }

    // Get all contracts
    public function index()
    {
        $contracts = Contract::orderBy('id','desc')->get();

        return response()->json([
            'status' => 200,
            'data' => $contracts,
        ]);
    }

    // Get a specific contract by ID
    public function show($id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found',
            ]);
        }

        return response()->json([
            'status' => 200,
            'data' => $contract,
        ]);
    }

    // Update a contract
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'accommodation_id' => 'exists:accommodations,id',
            'user_id' => 'exists:users,id',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
            'rate' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }

        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found',
            ]);
        }

        $contract->update($request->all());

        return response()->json([
            'status' => 200,
            'message' => 'Contract updated successfully',
            'data' => $contract,
        ]);
    }

    // Delete a contract
    public function destroy($id)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found',
            ]);
        }

        $contract->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Contract deleted successfully',
        ]);
    }
}
