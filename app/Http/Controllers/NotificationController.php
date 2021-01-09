<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function notification()
    {
        return [
            'notifications' => auth()->user()->notifications(),
            'numberOfUnreadNotifications' => auth()->user()->unreadNotifications()->count(),

        ];

    }

    public function readNotifications()
    {
         $user = auth()->user();
         $user->unreadNotifications()->update(['read_at' => now()]);

         return response('read',Response::HTTP_CREATED);
    }
}
