<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
// use Illuminate\Http\Request;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // INDEX
    public function index(Request $request)
    {

        $perPage = $request->perPage;
        $pageStart = \Request::get('page', 1);

        $offSet = ($pageStart * $perPage) - $perPage;
        $order = $request->SortField;
        $dir = $request->SortType;

        // Search
        $poropsal = Job::where('user_id', Auth::user()->id)->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('job_name', 'LIKE', "%{$request->search}%")
                    ->orWhere('sallary', 'LIKE', "%{$request->search}%")

                    ->orWhere(function ($query) use ($request) {
                        return $query->whereHas('category', function ($q) use ($request) {
                            $q->where('category_name', 'LIKE', "%{$request->search}%");
                        });
                    });
            });
        });

        $poropsal = $poropsal->offset($offSet)

            ->orderBy($order, $dir)
            ->paginate($perPage);

        return response()->json([
            'poropsal' => $poropsal,
        ]);
    }

    // STORE
    public function store(CreateJobRequest $request)
    {
        try {

            $job = Job::create([
                'user_id'               => $request->user()->id,
                'category_id'           => $request->category_id,
                'company_id'            => $request->user()->company->id,
                'job_name'              => $request->job_name,
                'job_description'       => $request->job_description,
                'published'             => $request->published,
            ]);

            return response()->json(['success' => true, 'message' => 'Job Created Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    public function update(UpdateJobRequest $request, $id)
    {
        try {

            $job = Job::find($id)
                ->update([
                    'category_id'           => $request->category_id,
                    'job_name'              => $request->job_name,
                    'job_description'       => $request->job_description,
                    'published'             => $request->published,
                ]);

            return response()->json(['success' => true, 'message' => 'Job Created Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    // DESTROY
    public function destroy($id)
    {
        try {
            $job = Job::find($id);
            $job->delete();

            return response()->json(['success' => true, 'message' => 'Job Deleted Successfully !']);
        } catch (Throwable $e) {
            return response()->json(['success' => false, 'message' => $e]);
        }
    }
}
