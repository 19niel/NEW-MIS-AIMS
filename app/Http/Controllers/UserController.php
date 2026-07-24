<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'data' => $this->userService->getAllUsers()
            ]);
        }
        return view('users.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|string|in:Admin,IT,Staff',
            'status' => 'required|in:Active,Disabled'
        ]);

        $user = $this->userService->createUser($data);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully!',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8',
            'role' => 'required|string|in:Admin,IT,Staff',
            'status' => 'required|in:Active,Disabled'
        ]);

        $user = $this->userService->updateUser($id, $data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }
}
