<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
    	
    	return view('notifications.index', [
    		'unreadNotifications' => auth()->user()->unreadNotifications,
    		'readNotifications' => auth()->user()->readNotifications,
    	]);
    }

    public function read($id)
    {
    	DatabaseNotification::find($id)->markAsRead();

    	return back();
    }


    public function destroy($id)
    {
    	DatabaseNotification::find($id)->delete();

    	return back();
    }
}
