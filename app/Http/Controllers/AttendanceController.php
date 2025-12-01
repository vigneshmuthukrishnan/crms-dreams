<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user');

        if ($request->fromdate && $request->todate) {
            $query->whereBetween('date', [$request->fromdate, $request->todate]);
        }

        if($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if($request->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('user_name', function($row) {
                    return $row->user->name ?? '—';
                })
                ->addColumn('date', function($row) {
                    return $row->date ?? '—';
                })
                // here time chagnes AM & PM format
                ->addColumn('login_time', function($row) {
                    return strtotime($row->login_time) ? date('h:i A', strtotime($row->login_time)) : '—';
                })
                ->addColumn('logout_time', function($row) {
                    return strtotime($row->logout_time) ? date('h:i A', strtotime($row->logout_time)) : '—';
                })
                ->addColumn('total_hours', function($row) {
                    if($row->login_time && $row->logout_time) {
                        $login = \Carbon\Carbon::parse($row->login_time);
                        $logout = \Carbon\Carbon::parse($row->logout_time);
                        $diff = $login->diff($logout);
                        return $diff->h . ' hrs ' . $diff->i . ' mins';
                    }
                    return '—';
                })
                ->rawColumns(['user_name', 'date', 'login_time', 'logout_time'])
                ->make(true);
        }
        return view('attendance.index');
    }



}