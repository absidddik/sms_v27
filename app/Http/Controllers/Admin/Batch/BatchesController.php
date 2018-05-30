<?php

namespace App\Http\Controllers\Admin\Batch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Batch;
use Session;

class BatchesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.batch.index')
        ->with('batches', Batch::all());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.batch.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'batch_number' => 'required|min:2|max:30',
            'session' => 'required|min:2|max:30'
        ]);

        if (Batch::create($request->all())) {
            Session::flash('success','Batch create successfull');
        }else {
            Session::flash('fail','Batch create failed');
        }
        return redirect()->back();
    }



    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        return view('admin.batch.edit')
        ->with('batch', Batch::find($id));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'batch_number' => 'required|min:2|max:30',
            'session' => 'required|min:2|max:30'
        ]);

        $batch = Batch::find($id);

        if ($batch->update($request->all())) {
            Session::flash('success','Batch update successfull');
        }else {
            Session::flash('fail','Batch update failed');
        }

        return redirect()->route('batch.index');

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $batch = Batch::find($id);

        if ($batch->delete()) {
            Session::flash('success','Batch delete successfull');
        }else {
            Session::flash('fail','Batch delete failed');
        }
        return redirect()->back();
    }
}
