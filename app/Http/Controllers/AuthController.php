<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function register(Request $request)
{
    // Log incoming request data
    \Log::info('Register Request Data:', $request->all());

    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed|min:8',

    ]);

    if ($validator->fails()) {
        \Log::error('Validation Errors:', $validator->errors()->toArray());
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'customer',
    ]);

    // Log successful registration
    \Log::info('User Registered:', ['user' => $user]);

    // Redirect to login page after registration
    return response()->json(['user' => $user, 'message' => 'Registration successful. Please log in.']);
}



// AuthController.php
public function login(Request $request)
{
    // Validate the request
    $credentials = $request->only('email', 'password');
    
       if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

    $user = auth()->user();
    return response()->json([
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role, // Ensure the role is returned
        ]
    ]);
}


    public function getUser(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateUser(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update($request->only('name', 'phone_number'));

        return response()->json($user);
    }
}