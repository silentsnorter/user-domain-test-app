<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a list of all registered users with their domains.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::with('domains')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(20);

        return view('user.index', compact('users'));
    }

    // TODO: Add user search/filter if needed.

    // TODO: Extract user listing logic to UserService for more complex logic if needed.
}
