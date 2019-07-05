<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Services\UsersService;
use App\Interest;
use App\Badge;
use App\FundingTarget;
use App\ReportCard;
use Session;
use App\Services\AwsService;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService,  AwsService $awsService){ // Make service accessible in controller
        $this->usersService = $usersService;  
        $this->awsService = $awsService; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        return $this->usersService->index($request);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $funding_target = DB::table('funding_targets')->where('status', '=', 'open')->where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
        $funding_target->isEmpty() ? $funding_target = false : $funding_target = $funding_target[0];
        return view('admin.users.show', ['user' => $user, 'funding_target' => $funding_target]);
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
}
