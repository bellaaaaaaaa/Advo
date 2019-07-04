<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\Scholar;
use App\Interest;
use App\Badge;
use App\FundingTarget;
use App\ReportCard;
use Session;
use App\Services\ScholarsService;
use App\Services\AwsService;

class ScholarController extends Controller
{
    protected $scholarsService;

    public function __construct(ScholarsService $scholarsService,  AwsService $awsService){ // Make service accessible in controller
        $this->scholarsService = $scholarsService;  
        $this->awsService = $awsService; 
    }

    public function index(Request $request){
        return $this->scholarsService->index($request);
    }

    public function edit(Scholar $scholar)
    {
        $interests = Interest::all();
        $interests2 = array();
        foreach ($interests as $interest){
            $interests2[$interest->id] = $interest->title;
        };
        $user = $scholar->user;
        $reportCards = ReportCard::where('user_id', $scholar->user_id);
        $fundingTarget = $scholar->funding_targets->where('status', 'open');
        return view('admin.scholars.edit', ['scholar' => $scholar, 'user' => $user, 'interests' => $interests2, 'report_cards' => $reportCards, 'fundingTarget' => $fundingTarget]);
    }
    public function update(Request $request, $id)
    {
        $scholarParams = json_decode($request->input('scholarParams'));
        dd($scholarParams);
        $user = User::find($scholarParams->user_id);
        $user->name = $scholarParams->name;
        $user->email = $scholarParams->email;
        $user->role = $scholarParams->role;
        $user->date_of_birth = $scholarParams->date_of_birth;
        $user->phone_number = $scholarParams->phone_number;
        $user->ic_passport_number = $scholarParams->ic_passport_number;
        $user->bio = $scholarParams->bio;

        // Set user avatar
        if($request->file('avatar')){
            if ($user->avatar != null){
                $this->awsService->removeUpload($user, $user->avatar, "Users/Profiles/User_".$user->id."/");
            }   
            $fileUrl = $this->awsService->upload($request, 'avatar', "Users/Profiles/User_".$user->id);
            $user->avatar = $fileUrl;
        }
        $user->save();

        // Add Interests
        $user->interests()->detach();
        foreach($scholarParams->interests as $interest){
            $user->interests()->attach($interest->id);
        }

        // Update existing report cards
        if(isset($scholarParams->newReportCards)) {
            $reportCards = $scholarParams->newReportCards;
            foreach($reportCards as $report){
                if($report->deleted == false){
                    is_numeric($report->id) ? $currentReport = (ReportCard::find($report->id)) : $currentReport = new ReportCard;
                    $currentReport->title = $report->title;
                    $currentReport->term_start = $report->term_start;
                    $currentReport->term_end = $report->term_end;
                    $currentReport->user_id = $user->id;
                    
                    $filePath = "belongs_to_rc_".strval($report->index);
                    if ($request->file($filePath)){
                        $filenamewithextension = $request->file($filePath)->getClientOriginalName(); 	//get filename with extension
                        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
                        $extension = $request->file($filePath)->getClientOriginalExtension(); //get file extension
                        $filenametostore =  "Users/ReportCards/User_".$user->id."/".$filename.'_'.time().'.'.$extension;	//filename to store
                        Storage::disk('s3')->put($filenametostore, fopen($request->file($filePath), 'r+'), 'public');	//Upload File to s3
                        $report_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
                        $currentReport->file = $report_url;
                    } else {
                      $currentReport->file = $report->file;
                    }
                    $currentReport->save();
                }
                if ($report->deleted == true && is_numeric($report->id)){
                    $currentReport = ReportCard::find($report->id);
                    $this->awsService->removeUpload($currentReport, $currentReport->file, "Users/ReportCards/User_".$user->id."/");
                    $currentReport->delete();
                }
            }
        }

        // Update funding targets
        if(isset($scholarParams->fundingTargets)){
            foreach($scholarParams->fundingTargets as $ft){
                if($ft->deleted == false){
                    is_numeric($ft->id) ? $currentFt = (FundingTarget::find($ft->id)) : $currentFt = new FundingTarget;
                    $currentFt->title = $ft->title;
                    $currentFt->amount = $ft->amount;
                    $currentFt->user_id = $user->id;
                } elseif ($ft->deleted == true && is_numeric($ft->id)) {
                    $currentFt = FundingTarget::find($ft->id);
                    $currentFt->status = 'closed';
                }
                $currentFt->save();
            }
        };
        Session::flash('success', 'User updated!');
        return route('users.show', ['user' => $user]);
    }
    public function scholar_interests($id) {
        $scholar = Scholar::find($id);
        return $scholar->interests;
    }
    public function available_interests($id) {
        $interests = Interest::whereDoesntHave('scholars', function($q) use ($id){ $q->where('scholar_id', $id); })->get()->all();
        return $interests;
    }
}
