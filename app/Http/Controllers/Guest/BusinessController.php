<?php

namespace App\Http\Controllers\Guest;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Http\Controllers\API\ResponseController;

class BusinessController extends Controller
{
    public function index () {
        $data = Business::where('isActive', 1)->latest()->get();
        return ResponseController::create(BusinessResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }
}
