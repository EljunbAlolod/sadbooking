<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class SuperAdminUserController extends Controller
{
    /**
     * Display a listing of landlords.
     */
    public function indexLandlords(): View
    {
        // Fetch all users with the Landlord role and count their properties
        return view('admin.users.landlords', [
            'landlords' => User::where('role', UserRole::Landlord)
                ->withCount('boardingHouses')
                ->latest()
                ->paginate(10),
        ]);
    }

    /**
     * Display a listing of tenants.
     */
    public function indexTenants(): View
    {
        // Fetch all users with the Tenant role and count their reservations
        return view('admin.users.tenants', [
            'tenants' => User::where('role', UserRole::Tenant)
                ->withCount('reservations')
                ->latest()
                ->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validate input data including unique email check
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Only update password if a new one was provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Redirect back to the appropriate listing page
        $redirectRoute = $user->role === UserRole::Landlord ? 'admin.landlords.index' : 'admin.tenants.index';

        return redirect()->route($redirectRoute)->with('success', 'User details updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Safety check: Prevent the authenticated admin from deleting their own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $roleLabel = $user->role->label();
        $user->delete();

        return back()->with('success', "$roleLabel has been successfully deleted.");
    }
}
