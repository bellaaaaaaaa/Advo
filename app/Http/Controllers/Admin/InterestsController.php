<?php

namespace App\Http\Controllers\Admin;
use App\Interest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Services\InterestsService;

class InterestsController extends Controller
{
    protected $interestsService;

    public function __construct(InterestsService $interestsService){ // Make service accessible in controller
        $this->interestsService = $interestsService;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->interestsService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.interests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required|max:255|unique:interests,title'
        ));
        $interest = new Interest;
        $interest->title = $request->title;
        $interest->save();
        return view('admin.interests.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Interest $interest)
    {
        dd($interest);
        // $interest = Interest::find($id);
        return view('admin.interests.edit', ['interest' => $interest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interest $interest)
    {
        $this->validate($request, array(
            'title' => 'required|max:255|unique:interests,title'
        ));
        $interest->title = $request->input('title');
        $interest->save();
        return view('admin.interests.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interest $interest){
        $interest->users()->detach();
        $interest->delete();
        return success();
    }
}
