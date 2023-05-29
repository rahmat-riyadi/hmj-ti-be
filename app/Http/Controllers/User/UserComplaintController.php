<?php

namespace App\Http\Controllers\User;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\ResponseController;

class UserComplaintController extends Controller
{
    public function index () {
        $data = Complaint::latest()->get();
        return ResponseController::create($data, 'success', 'Data retrieved successfully', 200);
    }
}
