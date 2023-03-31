<?php

namespace App\Http\Controllers\MasterTable;

use App\Models\DataPeminjaman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataPeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:data-peminjaman.index')->only('index');
        $this->middleware('permission:data-peminjaman.create')->only('create', 'store');
        $this->middleware('permission:data-peminjaman.edit')->only('edit', 'update');
        $this->middleware('permission:data-peminjaman.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('master-table.data-peminjaman.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataPeminjaman  $dataPeminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(DataPeminjaman $dataPeminjaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataPeminjaman  $dataPeminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPeminjaman $dataPeminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataPeminjaman  $dataPeminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataPeminjaman $dataPeminjaman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataPeminjaman  $dataPeminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataPeminjaman $dataPeminjaman)
    {
        //
    }
}
