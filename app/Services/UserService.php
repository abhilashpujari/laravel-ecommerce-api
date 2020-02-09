<?php

namespace App\Services;

use App\User;
use Illuminate\Http\Request;

/**
 * Class UserService
 * @package App\Services
 */
class UserService extends BaseService
{
    /**
     * @param Request $request
     * @return User
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ],
        [
            'email.required' => 'The :attribute field is required.',
            'email.email' => 'The :attribute field should be valid email.',
            'email.unique' => 'This email is already registered in our system.',
            'password.required' => 'The :attribute field is required.'
        ]);

        $user = new User();
        $data = $request->only($user->getFillable());
        $user->fill($data);
        $this->save($user);

        return $user;
    }
}
