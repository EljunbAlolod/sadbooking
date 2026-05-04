<?php

namespace App\Enums;

enum UtilityBillType: string
{
    case Electric = 'electric';
    case Water = 'water';

    /** Monthly boarding house (rent / BH fee) notice */
    case MonthlyBh = 'monthly_bh';

    public function label(): string
    {
        return match ($this) {
            self::Electric => __('Electric'),
            self::Water => __('Water'),
            self::MonthlyBh => __('Monthly boarding house'),
        };
    }
}
