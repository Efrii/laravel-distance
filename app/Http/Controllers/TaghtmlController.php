<?php

namespace App\Http\Controllers;

use App\Models\Taghtml;
use Illuminate\Http\Request;

class TaghtmlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taghtml = Taghtml::all();

        return view( 'dashboard/addweb' , [
            'title' => 'Add Website',
            'data' => $taghtml
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
            'taghtml'  => 'required',
        ]);

        Taghtml::create($validate);

        return redirect('dashboard/addweb');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Taghtml  $taghtml
     * @return \Illuminate\Http\Response
     */
    public function show(Taghtml $taghtml)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Taghtml  $taghtml
     * @return \Illuminate\Http\Response
     */
    public function edit(Taghtml $taghtml)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Taghtml  $taghtml
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'taghtml'  => 'required',
        ]);

        $taghtml = Taghtml::find($id);
        $taghtml->taghtml = $request->taghtml;
        $taghtml->save();

        return redirect('dashboard/addweb');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Taghtml  $taghtml
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taghtml $taghtml)
    {
        // Taghtml::destroy($taghtml->id);

        // return redirect('dashboard/addweb');
    }

    public function delete_single_data($id) {
        Taghtml::where('id', $id)->delete();
        
        return redirect('dashboard/addweb');
    }
}
