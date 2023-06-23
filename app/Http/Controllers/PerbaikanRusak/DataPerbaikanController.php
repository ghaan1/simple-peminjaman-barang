<?php

namespace App\Http\Controllers\PerbaikanRusak;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataPerbaikanRequest;
use App\Http\Requests\UpdateDataPerbaikanRequest;
use App\Models\DataPerbaikan;

class DataPerbaikanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rusak-perbaikan.perbaikan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rusak-perbaikan.perbaikan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDataPerbaikanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataPerbaikanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataPerbaikan  $dataPerbaikan
     * @return \Illuminate\Http\Response
     */
    public function show(DataPerbaikan $dataPerbaikan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataPerbaikan  $dataPerbaikan
     * @return \Illuminate\Http\Response
     */
    public function edit(DataPerbaikan $dataPerbaikan)
    {
        return view('rusak-perbaikan.perbaikan.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDataPerbaikanRequest  $request
     * @param  \App\Models\DataPerbaikan  $dataPerbaikan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDataPerbaikanRequest $request, DataPerbaikan $dataPerbaikan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataPerbaikan  $dataPerbaikan
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataPerbaikan $dataPerbaikan)
    {
        //
    }
}
