<?php

namespace App\Http\Controllers;

use App\Models\OwnerRequest;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerRequestController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        
        if ($user->role->name === 'admin') {
        return response()->json([
            'message' => 'Admins cannot request ownership'
        ], 403);
    }

        if ($user->role->name === 'restaurant') {
            return response()->json([
                'message' => 'You are already a restaurant owner'
            ], 400);
        }

        $exists = OwnerRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You already have a pending request'
            ], 400);
        }

        $ownerRequest = OwnerRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Request sent successfully',
            'data' => $ownerRequest
        ], 201);
    }

    public function status(Request $request)
    {
        $req = OwnerRequest::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        return response()->json([
            'status' => $req ? $req->status : null
        ]);
    }

    public function myRequests(Request $request)
    {
        return OwnerRequest::where('user_id', $request->user()->id)
            ->latest()
            ->get();
    }

    public function index()
    {
        return OwnerRequest::with('user')->latest()->get();
    }

    public function approve($id)
    {
        $ownerRequest = OwnerRequest::findOrFail($id);

        if ($ownerRequest->status !== 'pending') {
            return response()->json([
                'message' => 'Already processed'
            ], 400);
        }

        $user = User::findOrFail($ownerRequest->user_id);
        $user->role_id = 2;
        $user->save();

        $ownerRequest->status = 'approved';
        $ownerRequest->save();

        return response()->json([
            'message' => 'User promoted to restaurant owner'
        ]);
    }

    public function reject($id)
    {
        $ownerRequest = OwnerRequest::findOrFail($id);

        $ownerRequest->status = 'rejected';
        $ownerRequest->save();

        return response()->json([
            'message' => 'Request rejected'
        ]);
    }

    public function destroy($id)
    {
        OwnerRequest::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}