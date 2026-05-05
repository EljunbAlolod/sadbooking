<?php

namespace App\Enums;

/**
 * Defines the available user roles in the system.
 */
enum UserRole: string
{
    // Platform administrator with full access
    case SuperAdmin = 'super_admin';

    // Property owner who can manage listings and bills
    case Landlord = 'landlord';

    // Renter who can browse and reserve rooms
    case Tenant = 'tenant';

    /**
     * Returns a human-readable label for the user role.
     */
    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Administrator',
            self::Landlord => 'Landlord',
            self::Tenant => 'Tenant',
        };
    }
}
