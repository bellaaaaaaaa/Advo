<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\FundingTransactionsService;

use App\User;
use App\FundingPackage;

class FundingTransactionController extends Controller
{
    protected $fundingTransactionsService;

    public function __construct(FundingTransactionsService $fundingTransactionsService){ // Make service accessible in controller
        $this->fundingTransactionsService = $fundingTransactionsService;   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->fundingTransactionsService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.funding_transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $userdata = $request->all();
        return route('stripe.get');
        // return Redirect::route('stripe.get')->with( ['request' => $request] );
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_benefactors(){
        $benefactors = User::where('role', 1)->get();
        return $benefactors;
    }
    public function get_scholars(){
        $scholars = User::where('role', 2)->get();
        return $scholars;
    }
    public function get_scholar_funding_targets($user_id){
        $scholar = User::find($user_id);
        return $scholar->funding_targets;
    }
    public function get_funding_packages(){
        return FundingPackage::all();
    }
    public function get_scholar_name($user_id){
        $scholar = User::find($user_id);
        return $scholar->name;
    }
}
