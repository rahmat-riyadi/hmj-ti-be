<?php

namespace App\Http\Controllers\User;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseController;

class UserBusinessController extends Controller
{
    public function index () {
        $data = Business::latest()->get();
        return ResponseController::create($data, 'success', 'Data retrieved successfully', 200);
    }

    public function store (Request $request) {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "price" => "required|numeric|min:0",
            "isActive" => "required|boolean",
            "image" => "required|image",
        ]);

        $validated["image"] = basename($request->file('image')->store('business'));
        Business::create($validated);
        return ResponseController::create("", "Created", "successfully saved data", 201);
    }

    public function show (Business $business) {
        return ResponseController::create($business, "success", "Data retrieved successfully", 200);
    }

    public function update (Request $request, Business $business) {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "price" => "required|numeric|min:0",
            "isActive" => "required|boolean",
            "image" => "image",
        ]);
        if($request->file("image")){
            Storage::delete("business/$request->oldImage");
            $validated["image"] = basename($request->file('image')->store('business'));
        }
        $business->update($validated);
        return ResponseController::create("", "Success", "Data successfully updated", 200);
    }
    
    public function destroy (Business $business) {
        Storage::delete("business/$business->image");
        $business->delete();
        return ResponseController::create("", "Success", "Data successfully deleted", 200);
    }
}
