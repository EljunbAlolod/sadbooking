<?php

namespace App\Enums;

/**
 * Defines the lifecycle of a room reservation.
 */
enum ReservationStatus: string
{
    // Initial request submitted by a tenant
    case Pending = 'pending';

    // Landlord has reviewed and approved the request
    case Approved = 'approved';

    // Landlord has declined the request
    case Rejected = 'rejected';

    // Tenant has moved in and is currently staying
    case Active = 'active';

    // Stay has ended as planned
    case Completed = 'completed';

    // Request was withdrawn by the tenant or cancelled by the landlord
    case Cancelled = 'cancelled';
}
