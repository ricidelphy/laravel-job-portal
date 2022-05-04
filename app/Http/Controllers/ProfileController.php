<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\FreelancerProfile;
use App\Models\User;

class ProfileController extends Controller
{
    // DETAIL
    public function show()
    {
        $profile = User::with('profile')->where('id', Auth::user()->id)->first();

        return response()->json([
            'profile' => $profile,
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        try {

            request()->validate(
                [
                    'birthplace'       =>  'required',
                    'birthdate'        =>  'required',
                    'phone_number'     =>  'required',
                    'gender '          =>  'required',
                    'address'          =>  'required',
                    'resume_file'      =>  'required|mimes:pdf|max:10000',
                ],

            );

            if ($request->hasFile('resume_file')) {

                $resume = $request->file('resume_file');
                $filename = 'RESUME-' . rand(11111111, 99999999) . $resume->getClientOriginalName();
                $resume->storeAs('public/uploads/resume/', $filename);
            }

            $profile = FreelancerProfile::find($id);
            $profile->birthplace       = $request->birthplace;
            $profile->birthdate        = $request->birthdate;
            $profile->phone_number     = $request->phone_number;
            $profile->gender           = $request->gender; //1=men, 0=mowen
            $profile->address          = $request->address;
            $profile->resume_file      = $filename;
            $profile->update();

            return response()->json(['success' => true, 'message' => 'Update Successfully !']);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
