<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\School;
use App\Scholar;
use App\Interest;
use App\Badge;
use App\FundingTarget;
use App\ReportCard;
use Session;
use App\Services\ScholarsService;
use App\Services\AwsService;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
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
        $user = $scholar->user;
        $schools = School::all();
        $funding_target = $scholar->funding_targets->where('status', 'open')->sortByDesc('updated_at')->first();
        return view('admin.scholars.edit', ['schools' => $schools, 'scholar' => $scholar, 'funding_target' => $funding_target, 'user' => $scholar->user]);
    }
    public function update(Request $request, $id)
    {
        $scholarParams = json_decode($request->input('scholarParams'));
        dd($scholarParams);
        $scholar = Scholar::find($scholarParams->scholar_id);
        $scholar->user->name = $scholarParams->name;
        $scholar->user->email = $scholarParams->email;
        $scholar->user->role = $scholarParams->role;
        $scholar->user->date_of_birth = $scholarParams->date_of_birth;
        $scholar->user->phone_number = $scholarParams->phone_number;
        $scholar->user->ic_passport_number = $scholarParams->ic_passport_number;
        $scholar->user->bio = $scholarParams->bio;

        // Set user avatar
        if($request->file('avatar')){
            if ($scholar->user->avatar != null){
                $this->awsService->removeUpload($scholar->user, $scholar->user->avatar, "Users/Profiles/User_".$scholar->user->id."/");
            }   
            $fileUrl = $this->awsService->upload($request, 'avatar', "Users/Profiles/User_".$scholar->user->id);
            $scholar->user->avatar = $fileUrl;
        }
        $scholar->user->save();

        // Add Interests
        $scholar->interests()->detach();
        foreach($scholarParams->interests as $interest){
            $scholar->interests()->attach($interest->id);
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
                    $currentReport->scholar_id = $scholar->id;
                    
                    $filePath = "belongs_to_rc_".strval($report->index);
                    if ($request->file($filePath)){
                        $filenamewithextension = $request->file($filePath)->getClientOriginalName(); 	//get filename with extension
                        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
                        $extension = $request->file($filePath)->getClientOriginalExtension(); //get file extension
                        $filenametostore =  "Users/ReportCards/Scholar_".$scholar->id."/".$filename.'_'.time().'.'.$extension;	//filename to store
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
                    $this->awsService->removeUpload($currentReport, $currentReport->file, "Users/ReportCards/Scholar_".$scholar->id."/");
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
                    $currentFt->scholar_id = $scholar->id;
                    $currentFt->user_id = $scholar->user->id;
                } elseif ($ft->deleted == true && is_numeric($ft->id)) {
                    $currentFt = FundingTarget::find($ft->id);
                    $currentFt->status = 'closed';
                }
                $currentFt->save();
            }
        };
        Session::flash('success', 'User updated!');
        return route('users.show', ['user' => $scholar->user]);
    }
    public function scholar_interests($id) {
        $scholar = Scholar::find($id);
        return $scholar->interests;
    }
    public function available_interests($id) {
        $interests = Interest::all();
        return $interests;
    }
}
