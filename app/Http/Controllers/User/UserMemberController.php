<?php

namespace App\Http\Controllers\User;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\ResponseController;

class UserMemberController extends Controller
{
    public function index()
    {
        $data = Member::latest()->get();
        $modifiedData = $data->map(function ($member) {
            $member->photo = url("storage/$member->photo");
            return $member;
        });
        return ResponseController::create($data, 'success', "Data retrieved successfully", 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "photo" => "required|image|mimes:jpeg,png,jpg",
            "position" => "required|string",
        ]);

        $extension = $request->file('photo')->getClientOriginalExtension();
        $slug = Str::slug($validated['name']);
        $fileName = "$slug.$extension";
        $filePath = "member/$fileName";

        // Cek keberadaan name yang sama sudah ada dalam database
        $count = Member::where('photo', $filePath)->count();
        if ($count > 0) {
            $uniqueSlug = $slug . '-' . ($count + 1);
            $fileName = "$uniqueSlug.$extension";
            $filePath = "member/$fileName";
        }

        $request->file("photo")->storeAs('member', $fileName);

        $validated["photo"] = $filePath;
        
        Member::create($validated);
        return ResponseController::create("", "Created", "successfully saved data", 201);
    }

    public function show(Member $member)
    {
        $member->photo = url("storage/$member->photo");
        return ResponseController::create($member, 'success', 'Data retrieved successfully', 200);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "photo" => "nullable|image|mimes:jpeg,png,jpg",
            "position" => "required|string",
        ]);
        // jika user mengganti foto
        if ($request->hasFile("photo")) {
            // hapus foto lama
            Storage::delete($member->photo);
            // jika user mengganti foto dan name
            $extension = $request->file('photo')->getClientOriginalExtension();
            if ($request->name != $member->name) {
                $slug = Str::slug($validated['name']);
                $fileName = "$slug.$extension";
                $filePath = "member/$fileName";

                // Cek keberadaan namephoto yang sama sudah ada dalam database
                $count = Member::where('photo', $filePath)->count();
                if ($count > 0) {
                    $uniqueSlug = $slug . '-' . ($count + 1);
                    $fileName = "$uniqueSlug.$extension";
                    $filePath = "member/$fileName";
                }

                $request->file("photo")->storeAs('member', $fileName);

                $validated["photo"] = $filePath;
            // jika hanya mengganti photo
            } else {
                $fileName = basename($member->photo);
                $extensionOld = pathinfo($fileName, PATHINFO_EXTENSION); // Mengambil ekstensi dari nama file (misal: png)
                $fileNameOnly = str_replace('.' . $extensionOld, '', $fileName); // Menghapus ekstensi dari nama file
                $request->file("photo")->storeAs('member', $fileNameOnly.".".$extension);
                $validated["photo"] = "member/$fileNameOnly.$extension";
            }
            
        // jika user hanya mengganti nama
        } else if ($request->name != $member->name) {
            // ubah nama file gambar member
            $extension = pathinfo(Storage::url($member->photo), PATHINFO_EXTENSION);
            $slug = Str::slug($validated['name']);
            $fileName = "$slug.$extension";
            $filePath = "member/$fileName";
            Storage::move($member->photo, $filePath);

            // Cek keberadaan name yang sama sudah ada dalam database
            $count = Member::where('photo', $filePath)->count();
            if ($count > 0) {
                $uniqueSlug = $slug . '-' . ($count + 1);
                $fileName = "$uniqueSlug.$extension";
                $filePath = "member/$fileName";
            }
            // ubah path db photo
            $validated["photo"] = $filePath;
        }

        $member->update($validated);
        return ResponseController::create("", "Success", "Data successfully updated", 200);
    }

    public function destroy(Member $member)
    {
        Storage::delete($member->photo);
        $member->delete();
        return ResponseController::create("", "Success", "Data successfully deleted", 200);
    }
}
