<?php

namespace App\Http\Controllers\User;

use App\Models\Business;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseController;
use App\Http\Resources\BusinessResource;

class UserBusinessController extends Controller
{
    public function index()
    {
        $data = Business::latest()->get();
        return ResponseController::create(BusinessResource::collection($data), 'success', 'Data retrieved successfully', 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "price" => "required|numeric|min:0",
            "isActive" => "required|boolean",
            "image" => "required|image",
        ]);

        $validated["image"] = $request->file('image')->store('business');
        try {
            $business = Business::create($validated);
            return ResponseController::create(new BusinessResource($business), "Created", "successfully saved data", 201);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }

    public function show(Business $business)
    {
        return ResponseController::create(new BusinessResource($business), "success", "Data retrieved successfully", 200);
    }

    public function update(Request $request, Business $business)
    {
        $validated = $request->validate([
            "title" => "required",
            "description" => "required",
            "price" => "required|numeric|min:0",
            "isActive" => "required|boolean",
            "image" => "nullable|image",
        ]);
        if ($request->file("image")) {
            if ($business->image && Storage::exists($business->image)) {
                Storage::delete($business->image);
            }
            $validated["image"] = $request->file('image')->store('business');
        } else {
            unset($validated["image"]);
        }
        try {
            $business->update($validated);
            return ResponseController::create(new BusinessResource($business), "Success", "Data successfully updated", 200);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }

    public function destroy(Business $business)
    {
        try {
            if ($business->image && Storage::exists($business->image)) {
                Storage::delete($business->image);
            }
            $business->delete();
            return ResponseController::create("", "Success", "Data successfully deleted", 200);
        } catch (\Throwable $th) {
            return ResponseController::create(["error" => $th->getMessage()], "Internal Server Error", "Terjadi kesalahan pada server", 500);
        }
    }
}
