<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use Image;

class CompanyController extends Controller
{


    // STORE
    public function store(Request $request)
    {
        try {

            request()->validate(
                [
                    'user_id'          =>  'required',
                    'company_name'     =>  'required',
                    'about'            =>  'required',
                    'website'          =>  'required',
                ],

            );

            if ($request->hasFile('company_logo')) {

                $image = $request->file('company_logo');
                $filename = rand(11111111, 99999999) . $image->getClientOriginalName();

                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(400, 400);
                $image_resize->save(public_path('/images/company/' . $filename));
            } else {
                $filename = 'no-image.png';
            }

            $company = new Company;
            $company->user_id          = Auth::user()->id;
            $company->company_name     = $request->company_name;
            $company->company_logo     = $filename;
            $company->about            = $request->about;
            $company->website          = $request->website;
            $company->save();

            return response()->json(['success' => true, 'message' => 'Company Created Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
