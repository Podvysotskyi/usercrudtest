<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return Inertia::render('User/List', [
            'users' => UserResource::collection($users),
        ]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('edit-user', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return Inertia::render('User/Edit', [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Validate if user email is unique
        $request->validate([
            'email' => [Rule::unique('users')->ignore($user->id)],
        ]);

        // Change password if it was filled
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Unverify email if it was changed
        if ($request->input('email') !== $user->email) {
            $user->email_verified_at = null;
        }

        $user->fill($request->only(['name', 'email']));
        $user->save();

        return redirect()->route('users');
    }

    /**
     * Remove the specified user.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        // Do not allow user to delete himeself
        if ($user->id !== Auth::id()) {
            $user->delete();
        }
        return redirect()->route('users');
    }
}
