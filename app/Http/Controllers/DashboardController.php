<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;
        $currentYear  = now()->year;


        // if(auth()->user()->admin){
            // Copmany
            $countComp = Company::count();
            $currentMonthComp = Company::whereMonth('created_at', $currentMonth)->count();
            $lastTotalComp = Company::whereMonth('created_at', $lastMonth)->count();
            if ($lastTotalComp > 0) {
                $percentageChangeComp = (($currentMonthComp - $lastTotalComp) / $lastTotalComp) * 100;
            } else {
                $percentageChangeComp = 0;
            }

            // Lead
            $countLead = Lead::count();
            $currentYearLead = Lead::whereYear('created_at', now()->year)->count();
            $currentMonthLead = Lead::whereMonth('created_at', $currentMonth)->count();
            $lastTotalLead = Lead::whereMonth('created_at', $lastMonth)->count();
            if ($lastTotalLead > 0) {
                $percentageChangeLead = (($currentMonthLead - $lastTotalLead) / $lastTotalLead) * 100;
            } else {
                $percentageChangeLead = 0;
            }
            $monthlyLeads = Lead::select(DB::raw('MONTH(created_at) as month'),DB::raw('COUNT(*) as total'))
                ->whereYear('created_at', $currentYear)
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();
            $leadData = [];
            for ($m = 1; $m <= 12; $m++) {
                $leadData[] = $monthlyLeads[$m] ?? 0;
            }


            // User 
            $countUser = User::count();

            return view('dashboard', compact('countComp', 'percentageChangeComp', 'countLead', 'percentageChangeLead', 'currentYearLead', 'countUser', 'leadData'));
        // }
        // return view('dashboard_user');
    }
}
