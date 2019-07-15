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

    public function edit(Benefactor $benefactor)
    {
        $user = $benefactor->user;
        return view('admin.benefactors.edit', ['benefactor' => $benefactor, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $params = json_decode($request->input('benParams'));
        $ben = Benefactor::find($params->user_pivot_id);
        $user = $ben->user;

        // Update benefactor
        $ben->company = $params->company;
        $ben->position = $params->position;
        $ben->save();

        // Update user object
        $user->name = $params->name;
        $user->email = $params->email;
        $user->role = $params->role;
        $user->date_of_birth = $params->date_of_birth;
        $user->phone_number = $params->phone_number;
        $user->ic_passport_number = $params->ic_passport_number;
        $user->bio = $params->bio;

        $user->save();
        $date_from = $params->experiences[0]->date_from;
        $whatIWant = substr($date_from, strpos($date_from, "/") + 1); 
        dd($whatIWant);

        if(isset($params->experiences)) {
            $experiences = $params->experiences;
            foreach($experiences as $exp){
                if($exp->deleted == false){
                    is_numeric($experience->id) ? $currentExperience = (Experience::find($exp->id)) : $currentExperience = new Experience;
                    $currentExperience->benefactor_id = $ben->id;
                    $currentExperience->position = $exp->position;
                    $currentExperience->organisation = $exp->organisation;
                    $currentExperience->date_from = $exp->date_from;
                    $currentExperience->date_to = $exp->date_to;
                    $currentExperience->description = $exp->description;
                    $currentExperience->save();
                }
                if ($report->deleted == true && is_numeric($exp->id)){
                    $currentExperience = Experience::find($exp->id);
                    $currentExperience->delete();
                }
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}
