<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $limit = 10;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $limit;
        
        $query = Company::query();

        if ($request->name) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->name}%")
                    ->orWhere('email', 'like', "%{$request->name}%")
                    ->orWhere('phone_1', 'like', "%{$request->name}%")
                    ->orWhere('phone_2', 'like', "%{$request->name}%");
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->fromdate && $request->todate) {
            $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
        }

        if ($request->ajax()) {
            if($request->pagetype && $request->pagetype == 'list') {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('name', function($row) {
                        return $row->name ?? '—';
                    })
                    ->addColumn('phone', function($row) {
                        return $row->phone_1 ?? '—';
                    })
                    ->addColumn('email', function($row) {
                        return $row->email ?? '—';
                    })
                    ->addColumn('address', function($row) {
                        return  Str::limit($row->address, 20) ?? '—';
                    })
                    ->addColumn('status', function($row) {
                        $class = $row->status == 1 ? 'bg-success' : 'bg-danger';
                        $statusText = $row->status == 1 ? 'Active' : 'Inactive';
                        return '<span class="badge badge-pill '.$class.'">'.$statusText.'</span>';
                    })
                    ->addColumn('action', function($row) {
                        $previewUrl = route('companies.show', $row->id);
                        return '
                            <div class="dropdown table-action">
                                <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item edit-company" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                        <i class="ti ti-edit text-blue"></i> Edit
                                    </a>
                                    <a class="dropdown-item delete-company" href="#" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#delete_contact">
                                        <i class="ti ti-trash"></i> Delete
                                    </a>
                                    <a class="dropdown-item" href="'.$previewUrl.'">
                                        <i class="ti ti-eye text-blue-light"></i> Preview
                                    </a>
                                </div>
                            </div>
                        ';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } else {
                $total = $query->count();
                $companies = $query->latest()->offset($offset)->limit($limit)->get();
                $view = view('companies.company_cards', compact('companies'))->render();
                $hasMore = ($offset + $limit) < $total;
                return response()->json(['html' => $view,'hasMore' => $hasMore, 'nextPage' => $page + 1]);
            }
        }

        $companies = Company::latest()->take($limit)->get();
        $companycount = Company::count();
        $industrys = config('static.industrys');
        $sources = config('static.lead_sources');
        return view('companies.index', compact('companies','companycount', 'industrys', 'sources'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_1' => 'required|string|max:20',
                'source' => 'required|string|max:255',
                'industry' => 'required|string|max:255',
                'phone_2' => 'nullable|string|max:20',
                'fax' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'website' => 'nullable|url|max:255',
                'owner' => 'nullable|string|max:255',
                'tags' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'zipcode' => 'nullable|string|max:20',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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

            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validated['logo'] = $logoPath;
            }

            $company = new Company($validated);
            $company->created_by = Auth::id();
            $company->save();
            return redirect()->route('companies.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone_1' => 'nullable|string|max:20',
                'phone_2' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'website' => 'nullable|url|max:255',
                'owner' => 'nullable|string|max:255',
                'source' => 'nullable|string|max:255',
                'industry' => 'nullable|string|max:255',
                'tags' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'city' => 'nullable|string|max:100',
                'zipcode' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                if ($request->expectsJson()) {
                    $errors = $validator->errors()->all();
                    $errorMessage = implode(', ', $errors);
                    return response()->json(['success' => false, 'message' => $errorMessage], 422);
                }
                return back()->withErrors($validator)->withInput();
            }

            $company->update($validator->validated());
            $company->updated_by = Auth::id();
            $company->save();
            return response()->json(['success' => true, 'message' => 'Company updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function show(Request $request, $id)
    {
        try {
            $company = Company::findOrFail($id);
            $companycount = Company::count();
            return view('companies.show', compact('company','companycount'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }   

    public function edit($id)
    {
        try {
            $company = Company::findOrFail($id);
            $industrys = config('static.industrys');
            $sources = config('static.lead_sources');
            return view('companies.edit', compact('company', 'industrys', 'sources'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getIdLead($id)
    {
        try {
            $company = Company::findOrFail($id);
            $industrys = config('static.industrys');
            $sources = config('static.lead_sources');
            return response()->json(['success' => true, 'data' => $company ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // delete company
    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            $lead = Lead::where('company_id', $company->id)->get();
            if ($lead->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Cannot delete company with associated leads.'], 400);
            }
            $company->delete();
            return response()->json(['success' => true, 'message' => 'Company deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

