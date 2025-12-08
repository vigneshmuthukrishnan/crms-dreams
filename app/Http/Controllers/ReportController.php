<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function leads(Request $request)
    {
        $query = Lead::query();

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }
        if ($request->month) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->year) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $leads = $query->orderBy('id', 'desc')->paginate(10);
        $lead_status = config('static.lead_status');
        return view('reports.leads', compact('leads', 'lead_status'));
    }
}
