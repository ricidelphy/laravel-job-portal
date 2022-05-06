<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProposalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Proposal;

class HomeController extends Controller
{
    //
    // LIST JOB
    public function index()
    {
        $jobs = Job::with('category')->where('published', 1)->paginate(10);

        return response()->json([
            'data' => $jobs,
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
    public function apply(CreateProposalRequest $request)
    {
        try {

            if (Proposal::where('user_id', Auth::user()->id)->where('job_id', $request->job_id)->exists()) {
                return response()->json(['success' => false, 'message' => 'Proposal is Exists !']);
            } else {

                $proposal = Proposal::create([
                    'user_id'           =>  Auth::user()->id,
                    'job_id'            => $request->job_id,
                    'status'            => 'send', //send, review, assessment, offering, offered, unsuitable, hired
                ]);

                return response()->json(['success' => true, 'message' => 'Apply Successfully !']);
            }
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
