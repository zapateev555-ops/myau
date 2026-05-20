<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user()->load('profile');
        $orders = $user->orders()->latest()->get();

        return view('shop.profile', compact('user', 'orders'));
    }

    public function edit()
    {
        $profile = auth()->user()->profile ?? auth()->user()->profile()->create([]);

        return view('shop.edit_profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $profile = auth()->user()->profile ?? auth()->user()->profile()->create([]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $profile->update($data);

        return redirect()->route('profile')->with('success', 'Профиль обновлён');
    }
}
