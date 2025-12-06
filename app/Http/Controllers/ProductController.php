<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
 
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductDetail::query();
            if ($request->name) {
                $query->whereHas('product', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
                });
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function($row) {
                    return $row->product->name ?? '—';
                })
                ->addColumn('quantity', function($row) {
                    return $row->quantity ?? '—';
                })
                ->addColumn('cost', function($row) {
                    return $row->cost ?? '—';
                })
                ->addColumn('amount', function($row) {
                    return $row->amount ?? '—';
                })
                ->addColumn('gst', function($row) {
                    return $row->gst ?? '—';
                })
                ->addColumn('total', function($row) {
                    return $row->total ?? '—';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        $productCount = ProductDetail::count();
        return view('product.index', compact('productCount'));
    }
    
    public function getPackagesByProduct($productId)
    {
        $productDetails = ProductDetail::where('product_id', $productId)->get();
        return response()->json($productDetails);
    }
}
