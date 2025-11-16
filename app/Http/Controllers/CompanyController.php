<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $total = $query->count();
        $companies = $query->latest()->offset($offset)->limit($limit)->get();

        if ($request->ajax()) {
            $view = view('companies.company_cards', compact('companies'))->render();
            $hasMore = ($offset + $limit) < $total;
            return response()->json(['html' => $view,'hasMore' => $hasMore, 'nextPage' => $page + 1]);
        }

        $companies = Company::latest()->take($limit)->get();
        $companycount = Company::count();
        return view('companies.index', compact('companies','companycount'));
    }

    public function store(Request $request)
    {
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
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255', 
            'whatsapp_url' => 'nullable|url|max:255',
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
    }


    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
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
            'description' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255', 
        ]);

        if($request->expectsJson() && $validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()], 422);
        }

        $company->update($validated);
        $company->updated_by = Auth::id();
        $company->save();

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }


    public function show(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        $companycount = Company::count();
        return view('companies.show', compact('company','companycount'));
    }   

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    }
}

