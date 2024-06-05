<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'password' => 'required|string|min:8|confirmed',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imagePath = $image->store('images', 'public');
        } else {
            return response()->json(['errors' => 'Image upload failed'], 422);
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'country' => $request->country,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
            'image_path' => $imagePath,
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function companies()
    {
        return response()->json(Company::query()
        ->select('companies.*', DB::raw('(SELECT COUNT(company_id) FROM users WHERE users.company_id = companies.id) AS total_company_count'))
        ->whereNull('deleted_at')->get());
    }

    public function services()
    {
        return response()->json(Service::whereNull('deleted_at')->get());
    }

    public function countries()
    {
        return response()->json(Country::all());
    }

    public function getUser()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
