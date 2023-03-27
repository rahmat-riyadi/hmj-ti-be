<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController;

class ComplaintController extends Controller
{
    public function index () {
        $data = Complaint::latest()->get();
        return ResponseController::create($data, 'success', 'Data retrieved successfully', 200);
    }
}
