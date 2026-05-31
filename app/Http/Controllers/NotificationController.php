<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index($user_id)
    {
        $notifications = Notification::where(function ($q) use ($user_id) {
                $q->where('user_id', $user_id)
                  ->orWhereNull('user_id');
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Notifikasi berhasil diambil',
            'data' => $notifications
        ]);
    }

    public function read($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'status' => 'read'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notifikasi sudah dibaca',
            'data' => $notification
        ]);
    }
}