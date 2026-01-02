<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductDetail;
use App\Models\LeadActivity;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function leads(Request $request)
    {
        // set default current date filters input 
        $fromdate = date('Y-m-d');
        $todate = date('Y-m-d', strtotime('+7 days'));

        $user = auth()->user();
        $query = $user->admin ? LeadActivity::whereNotNull('next_action_date') : LeadActivity::whereNotNull('next_action_date')->where('created_by', $user->id);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->fromdate) {
            $fromdate = $request->fromdate;
            $query->whereDate('next_action_date', '>=', $request->fromdate);
        }

        $Leadactivitys = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();


        $lead_status = config('static.lead_status');

        return view('reports.leads', compact('Leadactivitys', 'lead_status', 'fromdate', 'todate'));
    }
}
