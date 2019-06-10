<?php

namespace App\Http\Controllers\Admin;
use App\Badge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Services\BadgesService;

class BadgesController extends Controller
{
    protected $badgesService;

    public function __construct(BadgesService $badgesService){ // Make service accessible in controller
        $this->badgesService = $badgesService;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->badgesService->index($request);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.badges.create');
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
            'title' => 'required|max:255|unique:badges,title'
        ));
        $badge = new Badge;
        $badge->title = $request->title;
        $badge->save();
        return view('admin.badges.index');
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
    public function edit(Badge $badge)
    {
        return view('admin.badges.edit', ['badge' => $badge]);
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
        $badge = Badge::find($id);
        if($badge->title == $request->input('title')){
            $this->validate($request, array(
                'title' => 'required|max:255'
            ));
        } else {
            $this->validate($request, array(
                'title' => 'required|max:255|unique:badges,title'
            ));
        };
        $badge->title = $request->input('title');
        $badge->save();
        return view('admin.badges.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Badge $badge)
    {
        $badge->users()->detach();
        $badge->delete();
        return success();
    }
}
