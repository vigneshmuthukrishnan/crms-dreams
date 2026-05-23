<?php

namespace App\Http\Controllers;

use App\Models\SmsLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
                            <a href="#" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="'.$previewUrl.'">
                                    <i class="ti ti-eye text-blue-light"></i> Preview
                                </a>
                                <button type="button" class="dropdown-item update-sms-lead-status" data-id="'.$row->id.'" data-status="open">
                                    <i class="ti ti-lock-open text-success"></i> Open Lead
                                </button>
                                <button type="button" class="dropdown-item update-sms-lead-status" data-id="'.$row->id.'" data-status="closed">
                                    <i class="ti ti-lock text-danger"></i> Close Lead
                                </button>
                            </div>
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

        return view('sms-leads.show', compact('smsLead'));
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
}
