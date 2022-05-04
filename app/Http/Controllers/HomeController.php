<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Proposal;

class HomeController extends Controller
{
    //
    // LIST JOB
    public function list_job()
    {
        $jobs = Job::with('category')->where('published', 1)->paginate(10);

        return response()->json([
            'jobs' => $jobs,
        ]);
    }

    // DETAIL
    public function show($id)
    {
        $job = Job::with('category')->where('id', $id)->where('published', 1)->first();

        return response()->json([
            'job' => $job,
        ]);
    }

    // APPLY
    public function apply(Request $request)
    {
        try {

            if (Proposal::where('job_id', $request->job_id)->exists()) {
                return response()->json(['success' => false, 'message' => 'Proposal is Exists !']);
            } else {
                request()->validate(
                    [
                        'job_id'        =>  'required',
                    ],
                );

                $proposal = new Proposal;
                $proposal->user_id      = Auth::user()->id;
                $proposal->job_id       = $request->job_id;
                $proposal->status       = 'send'; //send, review, assessment, offering, offered, unsuitable, hired
                $proposal->save();

                return response()->json(['success' => true, 'message' => 'Apply Successfully !']);
            }
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
