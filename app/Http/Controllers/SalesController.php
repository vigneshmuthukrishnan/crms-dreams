<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductDetail;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            $query = $user->admin ? Sale::query() : Sale::where('created_by', $user->id);

            if ($request->fromdate && $request->todate) {
                $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
            }
            // here changes  ajax to normal             
            // if ($request->ajax()) {
            //     return DataTables::of($query)
            //         ->addIndexColumn()
            //         ->addColumn('company', function($row) {
            //             return '
            //                 <h6 class="d-flex align-items-center fs-14 fw-medium mb-0">
            //                     <img class="w-auto h-auto" src="'.$row->company->LogoUrl.'" alt="User Image" style="width:30px !important; height:30px !important;">
            //                     '.$row->company->name.'<span class="text-body fs-13 mt-1 fw-normal">'.$row->lead->customer_name.'</span>
            //                 </h6>';
            //         })
            //         ->addColumn('product', function($row) {
            //             return $row->lead->product->name ?? 'N/A';
            //         })
            //         ->addColumn('package', function($row) {
            //             return $row->lead->package ?? 'N/A';
            //         })
            //         ->rawColumns(['company', 'product', 'package'])
            //         ->make(true);
            // }
            $clients = $query
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withQueryString();
            return view('sales.index', compact('clients'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}