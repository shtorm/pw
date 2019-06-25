<?php

namespace App\Http\Controllers;

use App\Account;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param string $method
     * @param array $parameters
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        if ($method != 'update' && $method != 'getList') {
            return parent::callAction($method, $parameters);
        }

        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isAdmin()) {
            return response()->json('No permission for this action.', 403);
        }

        return parent::callAction($method, $parameters);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = User::createWithAccount(array_merge(
            \request(['name', 'last_name', 'email']),
            [
                'status' => User::STATUS_ACTIVE,
                'password' => bcrypt($request->get('password'))
            ]
        ));

        Account::create($user->id);

        return response()->json($user);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make(array_merge(['id' => $id], $request->all()), [
            'id' => 'required|integer|exists:users,id',
            'name' => 'string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $id,
            'status' => 'integer|in:' . User::STATUS_ACTIVE . ',' . User::STATUS_DISABLE,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $user = User::find($id)->update(\request(['name', 'last_name', 'email', 'status']));

        return response()->json($user);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        return response()->json(User::all());
    }
}
