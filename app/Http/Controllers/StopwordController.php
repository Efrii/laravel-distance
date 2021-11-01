<?php

namespace App\Http\Controllers;

use App\Models\Stopword;
use Illuminate\Http\Request;

class StopwordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stopword = Stopword::all();

        return view('dashboard/stopword',[
            'title' => 'stopword',
            'data' => $stopword
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
            'stopword'  => 'required',
        ]);

        Stopword::create($validate);

        return redirect('dashboard/stopword');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stopword  $stopword
     * @return \Illuminate\Http\Response
     */
    public function show(Stopword $stopword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stopword  $stopword
     * @return \Illuminate\Http\Response
     */
    public function edit(Stopword $stopword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stopword  $stopword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $number)
    {

        $request->validate([
            'stopword'  => 'required',
        ]);

        $stopword = Stopword::find($number);
        $stopword->stopword = $request->stopword;
        $stopword->save();

        return redirect('dashboard/stopword');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stopword  $stopword
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stopword $stopword)
    {
        //
    }

    public function delete_single_data($number) {
        
        Stopword::where('number', $number)->delete();
        
        return redirect('dashboard/stopword');
    
    }

}
