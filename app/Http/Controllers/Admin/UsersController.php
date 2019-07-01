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
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
class UsersController extends Controller
{
    protected $usersService;

    public function __construct(UsersService $usersService){ // Make service accessible in controller
        $this->usersService = $usersService;   
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
        $badges = Badge::all();
        $badges2 = array();
        foreach ($badges as $badge){
            $badges2[$badge->id] = $badge->title;
        };
        $interests = Interest::all();
        $interests2 = array();
        foreach ($interests as $interest){
            $interests2[$interest->id] = $interest->title;
        };
        $user = User::find($id);
        $roles = ['Admin', 'Benefactor', 'Scholar'];
        $reportCards = ReportCard::where('user_id', $id);
        $fundingTarget = DB::table('funding_targets')->where('status', '=', 'open')->where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
        if (count($fundingTarget) == 0){
            $fundingTarget = 0;
        };
        return view('admin.users.edit', ['roles' => $roles, 'user' => $user, 'badges' => $badges2, 'interests' => $interests2, 'report_cards' => $reportCards, 'fundingTarget' => $fundingTarget]);
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
        $userParams = json_decode($request->input('userParams'));
        $rc = $userParams->newReportCards;
        $user = User::find($userParams->user_id);
        // $this->validate($request, array(
        //     'name' => 'required|max:255',
        //     //
        // ));
        $user->name = $userParams->name;
        $user->email = $userParams->email;
        $user->role = $userParams->role;
        $user->date_of_birth = $userParams->date_of_birth;
        $user->phone_number = $userParams->phone_number;
        $user->ic_passport_number = $userParams->ic_passport_number;
        $user->bio = $userParams->bio;

        $user->save();
        // Add Interests
        $user->interests()->detach();
        foreach($userParams->interests as $interest){
            $user->interests()->attach($interest->id);
        }

        // Add Badges
        $user->badges()->detach();
        foreach($userParams->badges as $badge){
            $user->badges()->attach($badge->id);
        }

        // dd(is_numeric($rc[0]->id));
        dd($rc);
        // Update existing report cards
        

        // $s3 = Storage::disk('s3');
        // $avatar = str_replace("https://s3-ap-southeast-1.amazonaws.com/advoedu-testing", '', $user->avatar);
        // $s3->delete($avatar);

        // $filenamewithextension = $request->file('cover_image')->getClientOriginalName(); 	//get filename with extension
        // $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
        // $extension = $request->file('cover_image')->getClientOriginalExtension(); //get file extension
        // $filenametostore =  "Users/Scholarposts/User_".$scholarPost->user_id."/".$filename.'_'.time().'.'.$extension;	//filename to store
        // Storage::disk('s3')->put($filenametostore, fopen($request->file('cover_image'), 'r+'), 'public');	//Upload File to s3
        // $report_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
        // $scholarPost->cover_image = $report_url;
        // $scholarPost->save();
        
        // if (isset($request->badges)) {
        //     $user->badges()->sync($request->badges, true);
        // } else {
        //     $user->badges()->sync(array());
        // }
        // if (isset($request->interests)) {
        //     $user->interests()->sync($request->interests, true);
        // } else {
        //     $user->interests()->sync(array());
        // }

        return view('admin.users.index');
        
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
    public function interests($id) {
        $user = User::find($id);
        return $user->interests()->get();
    }
    public function allinterests($id) {
        $interests = Interest::whereDoesntHave('users', function($q) use ($id){ $q->where('user_id', $id); })->get()->all();
        return $interests;
    }
    public function adduserinterest(Request $request, $id) {
        $user = User::find($id);
        $user->interests()->attach($request->interest_id);
        return $user->interests()->get();
        // return $user->interests();
    }
    public function deleteuserinterest(Request $request, $id) {
        $user = User::find($request->user_id);
        $user->interests()->detach($request->interest_id);
        return 204;
    }

    public function badges($id) {
        $user = User::find($id);
        return $user->badges()->get();
    }
    public function allbadges($id) {
        $badges = Badge::whereDoesntHave('users', function($q) use ($id){ $q->where('user_id', $id); })->get()->all();
        return $badges;
    }
    public function adduserbadge(Request $request, $id) {
        $user = User::find($id);
        $user->badges()->attach($request->badge_id);
        return $user->badges()->get();
    }
    public function deleteuserbadge(Request $request, $id) {
        $user = User::find($request->user_id);
        $user->badges()->detach($request->badge_id);
        return 204;
    }
    public function getselectedbadge(Request $request, $id) {
        dd($id);
    }

    // Update user routes
    public function get_user($id){
        $user = User::find($id);
        return $user;
    }
}
