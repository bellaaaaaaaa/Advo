<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ReportCard;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use App\Services\AwsService;

class ReportCardsController extends Controller
{
    protected $awsService;
	public function __construct(AwsService $awsService){ // Make service accessible in controller
		$this->awsService = $awsService;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReportCard::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.report_cards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filenamewithextension = $request->file('report_file')->getClientOriginalName(); 	//get filename with extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
        $extension = $request->file('report_file')->getClientOriginalExtension(); //get file extension
        $filenametostore = 'Users/Reportcards/'.$filename.'_'.time().'.'.$extension;	//filename to store
        Storage::disk('s3')->put($filenametostore, fopen($request->file('report_file'), 'r+'), 'public');	//Upload File to s3
        $report_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
       return ReportCard::create($request->all() + ['file' => $report_url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ReportCard::find($id);
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
        $rc = ReportCard::findOrFail($id);
        $rc->update($request->all());
        $this->awsService->removeUpload($rc, $rc->file, 'Users/Reportcards/');
        $this->awsService->uploadFile($request, $rc, 'report_file', 'Users/Reportcards/');
        return $rc;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rc = ReportCard::find($id);
        $this->awsService->removeUpload($rc, $rc->file, 'Users/Reportcards/');
        $rc->delete();
        return 204;
    }
}
