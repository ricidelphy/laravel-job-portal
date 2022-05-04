<?php

namespace App\Http\Controllers;

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
        $poropsal = Proposal::with('job', 'freelancer')->where('job_id', Auth::user()->job->id)->where(function ($query) use ($request) {
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

        $poropsal = $poropsal->offset($offSet)

            ->orderBy($order, $dir)
            ->paginate($perPage);

        return response()->json([
            'poropsal' => $poropsal,
        ]);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        try {
            request()->validate(
                [
                    'status'             =>  'required',
                ],
            );

            $proposal = Proposal::find($id);
            $proposal->status            = $request->status; //send, review, assessment, offering, offered, unsuitable, hired
            $proposal->save();

            return response()->json(['success' => true, 'message' => 'Update Proposal Successfully !']);
        } catch (Throwable $e) {

            return response()->json(['success' => false, 'message' => $e]);
        }
    }

    // DETAIL
    public function show($id)
    {
        $proposal = Proposal::with('job', 'freelancer')->where('id', $id)->first();
        return (new ProposalResource($proposal));
    }
}
