<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::all();

        if(isset($suppliers[0])){
            foreach($suppliers as $supplier){
                $suppliersArr[] = [
                    'code' => $supplier->code,
                    'name' => $supplier->name,
                    'created_at' => Carbon::parse($supplier->created_at)->format('d F Y H:i')
                ];
            }
        }else{
            $suppliersArr = null;
        }
        if($request->ajax()){
            return response()->json(['data' => $suppliersArr]);
        }else{
            return view('Pages.Admin.Page.Supplier.index', [
                'title' => 'Supplier',
                'suppliers' => $suppliers
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Admin.Page.Supplier.create', [
            'title' => 'Tambah Supplier'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'code' => 'required|unique:suppliers',
            'name' => 'required|unique:suppliers',
        ]);

        if($validate->fails()){
            $request->flashOnly(['code', 'name']);
            return back()->withErrors($validate->errors());
        }

        $validated = $validate->validated();
        try{
            Supplier::create($validated);
            return redirect('/admin/suppliers')->with('success', 'Data Supplier berhasil dibuat');
        }catch(\Exception $e){
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($code, Request $request)
    {
        if($request->ajax()){
            $suppliers = Supplier::where('code', $code)->first();
            return response()->json(['data' => $suppliers]);
        }else{
            abort(400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $validate = Validator::make($data, [
            'code' => 'required',
            'name' => 'required'
        ]);

        if($validate->fails()){
            return back()->withErrors($validate->errors());
        }

        $validated = $validate->validated();
        try{
            Supplier::where('code', $request->code)->update($validated);
            return back()->with('success', 'Data Supplier berhasil diperbarui');
        }catch(\Exception $e){
            return back()->withErrors($e->getmessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code, Request $request)
    {
        if($request->ajax()){
            Supplier::where('code', $code)->delete();
            return response()->json(['message', 'Data Supplier berhasil dihapus']);
        }else{
            abort(400);
        }
    }
}
