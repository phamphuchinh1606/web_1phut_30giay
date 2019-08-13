<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function daily(Request $request){
        $currentDate = DateTimeHelper::now();
        $branchId = 1;
    }
}
