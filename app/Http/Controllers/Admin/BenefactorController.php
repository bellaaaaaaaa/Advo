<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Benefactor;
use App\Scholar;
use App\Services\BenefactorsService;
use App\Services\AwsService;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class BenefactorController extends Controller
{
    protected $benefactorsService;

    public function __construct(BenefactorsService $benefactorsService,  AwsService $awsService){
        $this->benefactorsService = $benefactorsService;  
        $this->awsService = $awsService; 
    }

    public function index(Request $request){
        return $this->benefactorsService->index($request);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
