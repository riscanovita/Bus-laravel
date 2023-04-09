<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supir;
use Illuminate\Support\Facades\DB;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->get('q');
        $supirs = DB::table('supirs')
            ->where(function($query) use($q) {
                $query->where('no_reg', 'like', '%'.$q.'%')
                    ->orWhere('nama_lengkap', 'like', '%'.$q.'%');
            })
            ->orderByDesc('created_at')
            ->paginate(5);
            
        return response()->json($supirs);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_reg' => 'required',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'jk' => 'required|in:P,L'
        ]);

        $supirs = Supir::create($request->all());
        return response()->json($supirs);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supir $supir)
    {
        return response()->json($supir);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supir $supir)
    {
        $request->validate([
            'no_reg' => 'required',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'jk' => 'required|in:P,L'
        ]);

        $supir->no_reg = $request->no_reg;
        $supir->nama_lengkap = $request->nama_lengkap;
        $supir->alamat = $request->alamat;
        $supir->jk = $request->jk;
        $supir->save();

        return response()->json($supir);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supir $supir)
    {
        $supir->delete();
        return response()->json(['message' => 'supir berhasil dihapus!']);
    }
}
