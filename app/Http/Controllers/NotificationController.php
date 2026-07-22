<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function index(Request $request){
        $notifications = $request->user()->notifications;
        return response()->json([
            'notifications' => NotificationResource::collection($notifications)
        ],200);
    }

    public function unreadNotifications(Request $request){
        $unreadNotifications = $request->user()->unreadNotifications;
        return response()->json([
            'notifications' => NotificationResource::collection($unreadNotifications)
        ],200);
    }

    public function readNotifications(Request $request){
        $request->user()->notifications->update(['read_at' => now()]);
        return response()->json([
            'notifications' => true
        ],200);
    }
}
