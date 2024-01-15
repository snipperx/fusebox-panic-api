<?php

namespace App\Services;

use App\Models\Panic;
use Illuminate\Support\Facades\Auth;

class PanicAlertService
{
    public function persistPanicData($request, $panicID='')
    {
        return Panic::create(
            [
                'user_id' => Auth::id(),
                'longitude' => $request['longitude'] ?? '',
                'latitude' => $request['latitude'] ?? '',
                'panic_type' => $request['Panic_type']?? '',
                'details' => $request['details']?? '',
                'reference_id' => $request['reference_id'] ?? 0,
                'panic_id' => $panicID
            ]
        );
    }


}
