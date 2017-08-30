<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageUserController extends Controller
{

    public function __construct()
    {
        \View::share('queue_amount', count(\App\Task::queue()));
    }

    /**
     * The view of all users.
     */
    public function users() {
        return view('manage.user.show');
    }

}
