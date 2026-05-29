<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SmsLead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;

class SmsLeadController extends Controller
{
    public function index(Request $request)
    {
        $query = SmsLead::where('verification', '1');

        if ($request->name) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->name}%")
                    ->orWhere('phone', 'like', "%{$request->name}%")
                    ->orWhere('looking_for', 'like', "%{$request->name}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->fromdate && $request->todate) {
            $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
        }

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return '<a href="'.route('sms-leads.show', $row->id).'" class="d-flex flex-column">'.e($row->name ?? 'N/A').'</a>';
                })
                ->addColumn('phone', function ($row) {
                    return e($row->phone ?? 'N/A');
                })
                ->addColumn('looking_for', function ($row) {
                    return e($row->looking_for ?? 'N/A');
                })
                ->addColumn('verification', function ($row) {
                    return e($row->verification ?? 'N/A');
                })
                ->addColumn('status', function ($row) {
                    $status = strtolower($row->status ?? 'open');
                    $class = $status === 'closed' ? 'bg-danger' : 'bg-success';
                    return '<span class="badge badge-pill '.$class.'">'.ucfirst($status).'</span>';
                })
                ->addColumn('action', function ($row) {
                    $previewUrl = route('sms-leads.show', $row->id);
                    return '
                        <div class="dropdown table-action">
                            <a class="dropdown-item" href="'.$previewUrl.'">
                                <i class="ti ti-eye text-blue-light"></i> Preview
                            </a>
                        </div>
                    ';
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make(true);
        }

        $leadcount = SmsLead::count();

        return view('sms-leads.index', compact('leadcount'));
    }

    public function show($id)
    {
        $smsLead = SmsLead::findOrFail($id);
        $users = User::where('admin', 0)->orderBy('name')->get();

        return view('sms-leads.show', compact('smsLead', 'users'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,closed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(', ', $validator->errors()->all()),
            ], 422);
        }

        $smsLead = SmsLead::findOrFail($id);
        $smsLead->status = $request->status;
        $smsLead->save();

        return response()->json([
            'success' => true,
            'message' => 'SMS lead status updated successfully.',
        ]);
    }

    public function assignUser(Request $request, $id)
    {
        $ApiKey = "OToE0knDQApg571A";
        $SenderId = "MYDREM";

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => implode(', ', $validator->errors()->all()),
            ], 422);
        }

        $user = User::where('admin', 0)->find($request->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a valid non-admin user.',
            ], 422);
        }

        $smsLead = SmsLead::findOrFail($id);

        $company = Company::create([
            'name' => $smsLead->company_name ?: 'Lead Company #'.$smsLead->id,
            'email' => $smsLead->email ?? null,
            'phone_1' => $smsLead->phone,
            'owner' => $smsLead->name ?: 'Lead Name #'.$smsLead->id,
            'source' => 'google',
            'created_by' => $user->id,
        ]);
        $smsLead->status = 'closed';
        $smsLead->save();

        try {
            $message = "Dear ".$smsLead->name.", Thanks For Interest In Our Services. Account Manager ".$user->name." And Number ".$user->phone.". Feel Free To Contact For Consultation - My Dreams Team";
            $response = Http::get('http://app.mydreamstechnology.in/vb/apikey.php', [
                'apikey'  => $ApiKey,
                'senderid'=> $SenderId,
                'number'  => $smsLead->phone,
                'message' => $message,
            ]);
            // return redirect()->route('sms-leads.index')->with('success', 'SMS lead assigned and company created successfully.');
            return response()->json([
                'success' => true,
                'message' => 'SMS lead assigned and company created successfully.',
                'company_id' => $company->id,
            ]);
        } catch (\Exception $e) {
            // return redirect()->route('sms-leads.index')->with('error', $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'company_id' => $company->id,
                ]);
        }
    }
}
