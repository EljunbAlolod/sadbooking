<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Landlord = 'landlord';
    case Tenant = 'tenant';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Administrator',
            self::Landlord => 'Landlord',
            self::Tenant => 'Tenant',
        };
    }
}
