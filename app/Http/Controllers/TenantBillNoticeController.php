<?php

namespace App\Http\Controllers;

use App\Models\UtilityBill;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantBillNoticeController extends Controller
{
    public function index(Request $request): View
    {
        $tenantId = $request->user()->id;

        $newBillIds = UtilityBill::query()
            ->where('tenant_id', $tenantId)
            ->whereNull('tenant_viewed_at')
            ->pluck('id')
            ->all();

        $billNotices = UtilityBill::query()
            ->where('tenant_id', $tenantId)
            ->with(['room.boardingHouse'])
            ->latest('due_date')
            ->paginate(20);

        UtilityBill::query()
            ->where('tenant_id', $tenantId)
            ->whereNull('tenant_viewed_at')
            ->update(['tenant_viewed_at' => now()]);

        return view('tenant.bill-notices.index', [
            'billNotices' => $billNotices,
            'newBillIds' => $newBillIds,
        ]);
    }
}
