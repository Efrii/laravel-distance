<?php

namespace App\Http\Controllers;

use App\Models\Dataweb;
use Illuminate\Http\Request;

class DatawebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web',[
            'title' => 'web'
        ]);
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
        $validate = $request->validate([
            'nama' => 'required',
            'url' => 'required',
            'url_img' => 'required'
        ]);

        Dataweb::create($validate);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dataweb  $dataweb
     * @return \Illuminate\Http\Response
     */
    public function show(Dataweb $dataweb)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dataweb  $dataweb
     * @return \Illuminate\Http\Response
     */
    public function edit(Dataweb $dataweb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dataweb  $dataweb
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dataweb $dataweb)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dataweb  $dataweb
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dataweb $dataweb)
    {
        //
    }
}
