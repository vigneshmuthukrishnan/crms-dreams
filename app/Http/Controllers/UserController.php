<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lead;
use App\Models\Attendance;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query();

            if ($request->name) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->name}%")
                        ->orWhere('email', 'like', "%{$request->name}%")
                        ->orWhere('phone', 'like', "%{$request->name}%");
                });
            }

            if ($request->status) {
                $query->where('status', $request->status == 1 ? 1 : 0);
            }

            if ($request->fromdate && $request->todate) {
                $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->name ?? '—';
                })
                ->addColumn('phone', function($row) {
                    return $row->phone ?? '—';
                })
                ->addColumn('email', function($row) {
                    return $row->email ?? '—';
                })
                ->addColumn('company', function($row) {
                    return $row->company ?? '—';
                })
                ->addColumn('created', function($row) {
                    return $row->created_at ? $row->created_at->format('d M Y, h:i A') : '—';
                })
                ->addColumn('last_activity', function($row) {
                    return $row->updated_at ? $row->updated_at->diffForHumans() : '—';
                })
                ->addColumn('status', function($row) {
                    $class = $row->status == 1 ? 'bg-success' : 'bg-danger';
                    $statusText = $row->status == 1 ? 'Active' : 'Inactive';
                    return '<span class="badge badge-pill '.$class.'">'.$statusText.'</span>';
                })
                ->addColumn('action', function($row) {
                    if ($row->admin) {
                        $str = '';
                    } else {
                        $str = '<div class="dropdown table-action">
                            <a href="javascript:void(0);" class="action-icon btn btn-xs shadow btn-icon btn-outline-light" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item edit-user" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                    <i class="ti ti-edit text-blue"></i> Edit
                                </a>
                                <a class="dropdown-item delete-user" href="javascript:void(0);" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#delete_contact">
                                    <i class="ti ti-trash"></i> Delete
                                </a>
                            </div>
                        </div>';
                    }
                    return $str;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        $usercount = User::count();
        $user_company = config('static.user_company');
        return view('users.index', compact('usercount', 'user_company'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'company' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'password' => 'required|min:6|confirmed',
            ]);
            if($request->expectsJson() && $validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()], 422);
            }
            $validated = $validator->validated();
            $user = new User($validated);
            $user->phone = $request->phone ?? null;
            $user->company = $request->company ?? null;
            $user->status = $request->status == 1 ? 1 : 0;  
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['success' => true, 'message' => 'User created successfully!'], 201);
        } catch (\Exception $e) {;
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }

    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $lead = Lead::where('assignee', $user->id)->get();
            $attendance = Attendance::where('user_id', $user->id)->get();
            $company = Company::where('created_by', $user->id)->get();
            if ($lead->count() > 0 || $attendance->count() > 0 || $company->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Cannot delete user with existing relations.'], 400);
            }
            $user->delete();
            return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }

    }

    public function editUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user_company = config('static.user_company');
            return view('users.edit-user', compact('user', 'user_company'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|string|max:20',
                'company' => 'required|string|max:255',
                'status' => 'required|in:0,1',
                'password' => 'nullable|min:6|confirmed',
            ]);
            $user = User::findOrFail($id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'] ?? null;
            $user->company = $validated['company'] ?? null;
            $user->status = $validated['status'];
            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }
            $user->save();
            return response()->json(['success' => true, 'message' => 'User updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }
}
