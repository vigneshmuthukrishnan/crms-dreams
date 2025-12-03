<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Company;
use App\Models\BulkSmsPackage;
use App\Models\LeadActivity;
use Illuminate\Support\Facades\Validator;
use DataTables;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;   

        $query = Lead::query();

        if ($request->name) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->name}%")
                    ->orWhere('email', 'like', "%{$request->name}%")
                    ->orWhere('customer_name', 'like', "%{$request->name}%")
                    ->orWhere('company_name', 'like', "%{$request->name}%");
            });
        }

        if ($request->fromdate && $request->todate) {
            $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
        }

        if ($request->ajax()) {
            if($request->pagetype && $request->pagetype == 'list') {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user', function($row) {
                        $img = user_avatar($row->user->name);
                        return '
                            <h6 class="d-flex align-items-center fs-14 fw-medium mb-0">
                                <a href="#" class="avatar me-2">
                                    <img class="img-fluid rounded-circle" src="'.$img.'" alt="User Image" style="width:30px !important; height:30px !important;">
                                </a>
                                <a href="#" class="d-flex flex-column">'.$row->user->name.'</a>
                            </h6>
                        ';
                    })
                    ->addColumn('company_name', function($row) {
                        return '
                            <h6 class="d-flex align-items-center fs-14 fw-medium mb-0">
                            <a href="#" class="avatar border rounded p-1 me-2 rounded-circle">
                                <img class="w-auto h-auto" src="'.$row->company->LogoUrl.'" alt="User Image" style="width:30px !important; height:30px !important;">
                            </a>
                            <a href="#" class="d-flex flex-column">
                                '.$row->company->name.'<span class="text-body fs-13 mt-1 fw-normal">'.$row->company->state.', '.$row->company->country.' </span>
                            </a>
                        </h6>';
                    })
                    ->addColumn('status', function($row) {
                        return '<span class="badge badge-pill bg-success">'.$row->status.'</span>';
                    })
                    ->addColumn('action', function($row) {
                        $previewUrl = route('leads.show', $row->id);
                        return '
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item edit-user" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                        <i class="ti ti-edit text-blue"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-user" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#delete_contact">
                                        <i class="ti ti-trash"></i> Delete
                                    </a>
                                    <a class="dropdown-item" href="'.$previewUrl.'">
                                        <i class="ti ti-eye text-blue-light"></i> Preview
                                    </a>
                                </div>
                            </div>
                        ';
                    })
                    ->rawColumns(['user', 'company_name', 'status','action'])
                    ->make(true);
            } else {
                $total = $query->count();
                $leads = $query->latest()->offset($offset)->limit($limit)->get();
                $view = view('leads.cards', compact('leads'))->render();
                $hasMore = ($offset + $limit) < $total;
                return response()->json(['html' => $view,'hasMore' => $hasMore, 'nextPage' => $page + 1]);
            }
        }

        $leads = Lead::latest()->take($limit)->get();
        $leadcount = Lead::count();
        $companies = Company::all();
        $company_types = config('static.company_types');
        $lead_sources = config('static.lead_sources');
        $lead_status = config('static.lead_status');
        $packages = BulkSmsPackage::all();
        return view('leads.index', compact('leads','leadcount', 'companies', 'company_types', 'lead_sources', 'lead_status', 'packages'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'customer_name' => 'required|string',
            'company_type' => 'required|string',
            'lead_source' => 'required|string',
            'number' => 'required|string',
            'email' => 'required|email',
            'date' => 'required|date',
            // 'plan' => 'required|string',
            'package' => 'required|string',
            // 'amount' => 'required|numeric',
            'next_action_date' => 'required|date',
            'status' => 'required|string',
            'remarks' => 'required|string',
        ]);
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                $errors = $validator->errors()->all();
                $errorMessage = implode(', ', $errors);
                return response()->json(['success' => false, 'message' => $errorMessage], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        $lead = Lead::create($validated);
        $lead->company_name = $request->company_name;
        $lead->company_id = $request->company_id;
        $lead->assignee = auth()->user()->id;
        $lead->save();

        // here add first activity for lead creation
        // LeadActivity::create([
        //     'lead_id' => $lead->id,
        //     'name' => 'Lead Created',
        //     'type' => 'Calls',
        //     'date' => now()->toDateString(),
        //     'time' => now()->toTimeString(),
        //     'remarks' => $request->remarks,
        //     'next_action_date' => $request->next_action_date,
        //     'status' => $request->status,
        //     'created_by' => auth()->user()->id,
        //     'updated_by' => auth()->user()->id,
        // ]);

        return response()->json(['success' => true, 'message' => 'Lead created successfully!', 'lead' => $lead], 201);
    }

    public function show(Request $request,  $id)
    {
        $lead = Lead::findOrFail($id);
        $leadCount = Lead::count();
        $lead_status = config('static.lead_status');
        return view('leads.show', compact('lead', 'leadCount', 'lead_status'));
    }

    public function edit(Request $request, $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        //
    }


    // Lead Activities functions
    public function addActivity(Request $request, $leadId)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'activity_type' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'remarks' => 'required|string',
            'next_action_date' => 'required|date',
            'status' => 'required|string',
        ]);
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                $errors = $validator->errors()->all();
                $errorMessage = implode(', ', $errors);
                return response()->json(['success' => false, 'message' => $errorMessage], 422);
            }
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        $lead = Lead::findOrFail($leadId);

        $activity = LeadActivity::create([
            'lead_id' => $lead->id,
            'name' => $validated['name'],
            'type' => $validated['activity_type'],
            'date' => $validated['date'],
            'time' => $validated['time'],
            'remark' => $validated['remarks'],
            'next_action_date' => $validated['next_action_date'],
            'status' => $validated['status'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Activity added successfully!', 'activity' => $activity], 201);
    }
}
