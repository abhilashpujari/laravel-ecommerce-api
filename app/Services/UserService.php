<?php

namespace App\Services;

use App\Exceptions\HttpUnauthorizedException;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $this->mapDataToModel($request, $user);
        $this->save($user);

        return $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object
     * @throws HttpUnauthorizedException
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ],
        [
            'email.required' => 'The :attribute field is required.',
            'email.email' => 'The :attribute field should be valid email.',
            'password.required' => 'The :attribute field is required.'
        ]);

        $user = $this->findOneBy('users', ['email' => $request->get('email')]);

        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            throw new HttpUnauthorizedException('Invalid email or password');
        }

        return $user;
    }
}
