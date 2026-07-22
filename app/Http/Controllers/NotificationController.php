<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function getAllNotifications(Request $request){
        $notifications = $request->user()->notifications;
        return response()->json([
            'notifications' => NotificationResource::collection($notifications)
        ],200);
    }

    public function getUnReadNotifications(Request $request){
        $unreadNotifications = $request->user()->unreadNotifications;
        return response()->json([
            'notifications' => NotificationResource::collection($unreadNotifications)
        ],200);
    }

    public function getReadNotifications(Request $request){
        $unreadNotifications = $request->user()->readNotifications;
        return response()->json([
            'notifications' => NotificationResource::collection($unreadNotifications)
        ],200);
    }

    public function readingUserNotifications(Request $request){
        $request->user()->unreadNotifications()->update(['read_at' => now()]);
        return response()->json([
            'notifications' => true
        ],200);
    }
}
