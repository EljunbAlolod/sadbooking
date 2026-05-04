<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            UserRole::SuperAdmin => redirect()->route('admin.dashboard'),
            UserRole::Landlord => redirect()->route('landlord.dashboard'),
            UserRole::Tenant => redirect()->route('tenant.dashboard'),
        };
    }
}
