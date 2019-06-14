<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FundingPackagesService;
use App\FundingPackage;

class FundingPackageController extends Controller
{
    protected $fundingPackages;
    public function __construct(FundingPackagesService $fundingPackages){ // Make service accessible in controller
        $this->fundingPackagesService = $fundingPackages;   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->fundingPackagesService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = ['a' => 'A', 'b' => 'B', 'c'=> 'C'];
        return view('admin.funding_package.create')->withOptions($options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fundingPackage = FundingPackage::create($request->all());
        return view('admin.funding_package.index');
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
    public function edit($id)
    {
        $fundingPackage = FundingPackage::find($id);
        $options = ['a' => 'A', 'b' => 'B', 'c'=> 'C'];
        return view('admin.funding_package.edit', ['options' => $options, 'fundingPackage' => $fundingPackage]);
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
        $fundingPackage = FundingPackage::find($id);
        $fundingPackage->update($request->input());
        $fundingPackage->save();
        return view('admin.funding_package.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fundingPackage = FundingPackage::find($id);
        $fundingPackage->delete();
        return view('admin.funding_package.index');
    }
}
