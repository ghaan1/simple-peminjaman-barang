<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataRusakRequest;
use App\Http\Requests\UpdateDataRusakRequest;
use App\Models\DataRusak;

class DataRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDataRusakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDataRusakRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DataRusak  $dataRusak
     * @return \Illuminate\Http\Response
     */
    public function show(DataRusak $dataRusak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DataRusak  $dataRusak
     * @return \Illuminate\Http\Response
     */
    public function edit(DataRusak $dataRusak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDataRusakRequest  $request
     * @param  \App\Models\DataRusak  $dataRusak
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDataRusakRequest $request, DataRusak $dataRusak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DataRusak  $dataRusak
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataRusak $dataRusak)
    {
        //
    }
}
