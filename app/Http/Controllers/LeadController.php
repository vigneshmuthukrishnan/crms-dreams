<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Company;
use App\Models\LeadActivity;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DataTables;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;   
        $user = auth()->user();

        $query = $user->admin ? Lead::query() : Lead::where('assignee', $user->id);

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
                                    <a class="dropdown-item edit-lead" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                        <i class="ti ti-edit text-blue"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-lead" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#delete_contact">
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
        if(auth()->user()->admin){
            $companies = Company::all();
        } else {
            $companies = Company::where('created_by', auth()->user()->id)->get();
        }
        $company_types = config('static.company_types');
        $lead_sources = config('static.lead_sources');
        $lead_status = config('static.lead_status');
        $icons = config('static.products_icon');
        $users = User::where('admin', '0')->get();
        $products = Product::all();
        return view('leads.index', compact('leads','leadcount', 'companies', 'company_types', 'lead_sources', 'lead_status', 'products', 'icons','users'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string',
                'company_type' => 'required|string',
                'lead_source' => 'required|string',
                'number' => 'required|string',
                'email' => 'required|email',
                'date' => 'required|date',
                'product' => 'required|string',
                'package' => 'required|string',
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
    
            $lead = Lead::create($validated);
            $lead->company_name = $request->company_name;
            $lead->company_id = $request->company_id;
            $lead->plan = $request->product;
            if(auth()->user()->admin && $request->user_id){
                $lead->assignee = $request->user_id;
            } else {
                $lead->assignee = auth()->user()->id;
            }
            $lead->save();
            return response()->json(['success' => true, 'message' => 'Lead created successfully!', 'lead' => $lead], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        } 
    }

    public function show(Request $request,  $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            if($lead){
                $leadCount = Lead::count();
                $products = Product::where('id', $lead->plan)->first();
                $packages = ProductDetail::where('id', $lead->package)->first();
                $lead_status = config('static.lead_status');
                return view('leads.show', compact('lead', 'leadCount', 'lead_status', 'products', 'packages'));
            }
            return redirect()->route('leads.index')->with('error', 'Lead not found.');
        }  catch (\Exception $e) {
            return redirect()->route('leads.index')->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $companies = Company::all();
            $company_types = config('static.company_types');
            $lead_sources = config('static.lead_sources');
            $lead_status = config('static.lead_status');
            $icons = config('static.products_icon');
            $products = Product::all();
            return view('leads.edit', compact('lead', 'companies', 'company_types', 'lead_sources', 'lead_status', 'icons', 'products'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
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
            $lead->update($validator->validated());
            // $lead->updated_by = Auth::id();
            $lead->save();
            return response()->json(['success' => true, 'message' => 'Lead updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $lead = Lead::findOrFail($id);
            $lead->delete();
            return response()->json(['success' => true, 'message' => 'Lead deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    // Lead Activities functions
    public function addActivity(Request $request, $leadId)
    {
        $validator = Validator::make($request->all(), [
            'activity_type' => 'required|string',
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
            'type' => $validated['activity_type'],
            'remark' => $validated['remarks'],
            'next_action_date' => $validated['next_action_date'],
            'status' => $validated['status'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Activity added successfully!', 'activity' => $activity], 201);
    }
}
