<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Create a new booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_date' => 'required|date',
            'name' => 'required|string',
            'email' => 'required|email',
            'contract_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Fails',
                'errors' => $validator->errors(),
            ]);
        }

        // Check if booking dates are within contract dates
        $bookingDate = \Carbon\Carbon::parse($request->input('booking_date'));

        $contractId = $request->input('contract_id');
        $contract = Contract::find($contractId);

        if (!$contract) {
            return response()->json([
                'status' => 404,
                'message' => 'Contract not found.',
            ]);
        }


        if (!$contract->isDateWithinContract($bookingDate)) {
            return response()->json([
                'status' => 400,
                'message' => 'Booking date is not within the contract dates.',
            ]);
        }

        $booking = Booking::create([
            'contract_id' => $contractId,
            'date' => $bookingDate,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'Booking created successfully',
            'data' => $booking,
        ]);
    }
}
