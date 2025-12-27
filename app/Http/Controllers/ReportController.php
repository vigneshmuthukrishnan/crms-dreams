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
        $user = auth()->user();
        $query = $user->admin ? Lead::query() : Lead::where('assignee', $user->id);
        
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('email', 'like', '%' . $request->name . '%')
                ->orWhere('number', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->filled('fromdate') && $request->filled('todate')) {
            $query->whereBetween('created_at', [
                $request->fromdate . ' 00:00:00',
                $request->todate . ' 23:59:59'
            ]);
        }
        
        $leads = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $lead_status = config('static.lead_status');

        return view('reports.leads', compact('leads', 'lead_status'));
    }
}
