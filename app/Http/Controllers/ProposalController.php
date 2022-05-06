<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProposalRequest;
use Illuminate\Http\Request;
use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProposalResource;

class ProposalController extends Controller
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
        $proposal = Proposal::with('job', 'freelancer')->where('job_id', Auth::user()->job->id)->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('status', 'LIKE', "%{$request->search}%")

                    ->orWhere(function ($query) use ($request) {
                        return $query->whereHas('job', function ($q) use ($request) {
                            $q->where('job_name', 'LIKE', "%{$request->search}%");
                        });
                    })
                    ->orWhere(function ($query) use ($request) {
                        return $query->whereHas('user', function ($q) use ($request) {
                            $q->where('name', 'LIKE', "%{$request->search}%");
                        });
                    })
                    ->orWhere(function ($query) use ($request) {
                        return $query->whereHas('user', function ($q) use ($request) {
                            $q->where('email', 'LIKE', "%{$request->search}%");
                        });
                    });
            });
        });

        $proposal = $proposal->offset($offSet)

            ->orderBy($order, $dir)
            ->paginate($perPage);

        return response()->json([
            'proposals' => $proposal,
        ]);
    }

    // UPDATE
    public function update(UpdateProposalRequest $request, $id)
    {
        try {

            $proposal = Proposal::find($id)->update([
                'status'        => $request->status, //send, review, assessment, offering, offered, unsuitable, hired
            ]);

            return response()->json(['success' => true, 'data' => $proposal, 'message' => 'Update Proposal Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    // DETAIL
    public function show($id)
    {
        $proposal = Proposal::with('job', 'freelancer')->where('job_id', Auth::user()->job->id)->where('id', $id)->first();
        return (new ProposalResource($proposal));
    }
}
