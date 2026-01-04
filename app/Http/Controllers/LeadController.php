<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use App\Models\Company;
use App\Models\LeadActivity;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use App\Models\Sale;
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

        $query = $user->admin ? Lead::where('convert_sales', 0) : Lead::where('assignee', $user->id)->where('convert_sales', 0);

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
                        $previewUrl = route('leads.show', $row->id);
                        return '
                            <h6 class="d-flex align-items-center fs-14 fw-medium mb-0">
                            <a href="'.$previewUrl.'" class="avatar border rounded p-1 me-2 rounded-circle">
                                <img class="w-auto h-auto" src="'.$row->company->LogoUrl.'" alt="User Image" style="width:30px !important; height:30px !important;">
                            </a>
                            <a href="'.$previewUrl.'" class="d-flex flex-column">
                                '.$row->company->name.'<span class="text-body fs-13 mt-1 fw-normal">'.$row->company->state.', '.$row->company->country.' </span>
                            </a>
                        </h6>';
                    })
                    ->addColumn('customer_name', function($row) {
                        return $row->company->owner ?? '-';
                    })
                    ->addColumn('status', function($row) {
                        if($row->activitiestatus->first()){
                            $str = setColorStatus($row->activitiestatus->first()->status);
                        } else {
                            $str = setColorStatus($row->status);
                        }
                        return $str;
                    })
                    ->addColumn('action', function($row) {
                        $previewUrl = route('leads.show', $row->id);
                        return '
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="'.$previewUrl.'">
                                        <i class="ti ti-eye text-blue-light"></i> Preview
                                    </a>
                                    <a class="dropdown-item edit-lead" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                        <i class="ti ti-edit text-blue"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-lead" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#delete_contact">
                                        <i class="ti ti-trash"></i> Delete
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
                'lead_source' => 'required|string',
                'number' => 'required|string',
                'email' => 'required|email|unique:leads,email',
                'date' => 'required|date',
                'product' => 'required|string',
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
                $packages = $lead->package ? ProductDetail::where('id', $lead->package)->first() : null;
                $lead_status = config('static.lead_status');
                $sales_types = config('static.sales_types');
                $payment_modes = config('static.payment_mode');
                $allproducts = Product::all();
                // here get all activities of lead any one close meant lead is closed set one var to open / close activities
                $activities = LeadActivity::where('lead_id', $lead->id)->get();
                if($activities){
                    $lead->is_closed = $activities
                        ->whereIn('status', ['Closed'])
                        ->isNotEmpty();

                    $lead->is_invalid = !$lead->is_closed && $activities
                        ->whereIn('status', ['Invalid Number', 'Junk'])
                        ->isNotEmpty();

                    $lead->is_next_callback = !$lead->is_closed && !$lead->is_invalid && $activities
                        ->whereIn('status', [
                            'RNR',
                            'Followup',
                            'Not Interested',
                            'Future Requirement'
                        ])
                        ->isNotEmpty();
                }
                
                return view('leads.show', compact('lead', 'leadCount', 'lead_status', 'products', 'packages', 'allproducts', 'sales_types', 'payment_modes'));
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
        if($request->status == 'Invalid Number' || $request->status == 'Junk'){
            $valid = [
                'activity_type' => 'required|string',
                'status' => 'required|string',
            ];
        } else if($request->status == 'Closed') {
            $valid = [
                'activity_type' => 'required|string',
                'status' => 'required|string',

                'company_id' => 'required|exists:companies,id',
                'lead_id' => 'required|exists:leads,id',
                
                'sales_type' => 'required|string',
                'payment_mode' => 'required|string',

                'product' => 'required|string',
                'package' => 'required|string',

                'amount' => 'required|numeric',
                'gst' => 'nullable|numeric',
                'total' => 'required|numeric',
            ];
        } else {
            $valid = [
                'activity_type' => 'required|string',
                'remarks' => 'required|string',
                'next_action_date' => 'required|date',
                'status' => 'required|string',
            ];
        }
        $validator = Validator::make($request->all(), $valid);
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
            'remark' => $validated['remarks'] ?? null,
            'next_action_date' => $validated['next_action_date'] ?? null,
            'status' => $validated['status'],
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        if($request->status == 'Followup' && $request->product && $request->package){
            $lead->plan = $request->product;
            $lead->package = $request->package;
        }
        if($request->status == 'Closed'){
            $sale = Sale::create([
                'company_id' => $validated['company_id'],
                'lead_id' => $validated['lead_id'],
                'date' => now(),

                'type' => $validated['sales_type'],
                'payment_mode' => $validated['payment_mode'],
                'transaction_details' => $validated['transaction_details'] ?? null, 

                'product' => $validated['product'] ?? null,  
                'package' => $validated['package'] ?? null,  

                'amount' => $validated['amount'] ?? 0,
                'gst' => $validated['gst'] ?? 0,
                'grand_total' => $validated['total'] ?? 0,
                'created_by' => auth()->user()->id,
            ]);

            $lead->convert_sales = 1;
        }
        $lead->save();
        return response()->json(['success' => true, 'message' => 'Activity added successfully!', 'activity' => $activity], 201);
    }


}
