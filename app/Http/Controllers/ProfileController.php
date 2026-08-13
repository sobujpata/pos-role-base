<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user()->load('profile');

        return view('backend.pages.profile.index', compact('user'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        $profile = $user->profile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $profile->phone = $data['phone'] ?? null;
        $profile->address = $data['address'] ?? null;
        $profile->nid_no = $data['nid_no'] ?? null;

        if ($request->hasFile('image')) {
            if ($profile->image && Storage::disk('public')->exists($profile->image)) {
                Storage::disk('public')->delete($profile->image);
            }

            $profile->image = $request->file('image')->store('profile-images', 'public');
        }

        $profile->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function destroy(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->profile && $user->profile->image && Storage::disk('public')->exists($user->profile->image)) {
            Storage::disk('public')->delete($user->profile->image);
        }

        $user->delete();

        return redirect()->route('login')->with('status', 'Your profile was deleted.');
    }
}
