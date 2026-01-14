<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Product;
use App\Models\Company;
use App\Models\ProductDetail;
use App\Models\LeadActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function calendar(Request $request)
    {
        try {
            $currentMonth = Carbon::now()->month;
            $startOfNextMonth = Carbon::now()->addMonth()->startOfMonth();
            // next action date only get current month 
            $user = auth()->user();
            $query = $user->admin ? LeadActivity::whereNotNull('next_action_date')->whereMonth('next_action_date', $currentMonth) : LeadActivity::whereNotNull('next_action_date')->whereMonth('next_action_date', $currentMonth)->where('created_by', $user->id);
            
            $activities = $query->get();
            $data = [];
            $backgroundColorArr = ['#FD3995', '#F7B924', '#34C38F', '#50A5F1'];
            $textColorArr = ['#FD3995', '#F7B924', '#34C38F', '#50A5F1'];
            $i = 1;
            foreach ($activities as $activity) {
                $data[] = [ 
                    'title' => trim($activity->company->name),
                    'start' => $activity->next_action_date,
                    'backgroundColor' => $backgroundColorArr[$i % count($backgroundColorArr)],
                    'textColor' => '#fff',
                    'extendedProps' => [
                        'company'     => 'Meeting with '.trim($activity->company->name),
                        'phone'       => $activity->lead->number ?? '',
                        'email'       => $activity->lead->email ?? '',
                        'customer'    => trim($activity->lead->customer_name),
                        'follow_date' => Carbon::parse($activity->next_action_date)->format('d M, Y'),
                        'created_by'  => $activity->user->name ?? 'Admin',
                        'remark'     => $activity->remark ?? '',
                    ]
                ];
                $i++;
            }
            return view('reports.calendar', compact('activities', 'data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while generating the calendar: ' . $e->getMessage());
        }
    }
}