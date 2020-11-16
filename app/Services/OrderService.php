<?php


namespace App\Services;

use Illuminate\Http\Request;

class OrderService extends BaseService
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3'
        ],
            [
                'email.required' => 'The :attribute field is required.',
                'email.email' => 'The :attribute field should be valid email.',
                'email.unique' => 'This email is already registered in our system.',
                'password.required' => 'The :attribute field is required.'
            ]);

    }
}
