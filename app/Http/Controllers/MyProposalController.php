<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proposal;
use App\Http\Resources\MyProposalResource;
use Illuminate\Support\Facades\Auth;

class MyProposalController extends Controller
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
        $poropsal = Proposal::with('job')->where('user_id', Auth::user()->id)->where(function ($query) use ($request) {
            return $query->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('status', 'LIKE', "%{$request->search}%")

                    ->orWhere(function ($query) use ($request) {
                        return $query->whereHas('job', function ($q) use ($request) {
                            $q->where('job_name', 'LIKE', "%{$request->search}%");
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

    // DETAIL
    public function show($id)
    {
        $proposal = Proposal::where('user_id', Auth::user()->id)->with('job')->where('id', $id)->first();
        return (new MyProposalResource($proposal));
    }
}
