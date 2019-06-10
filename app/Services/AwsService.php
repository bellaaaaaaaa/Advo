<?php 

namespace App\Services;
use App\User;
use App\ReportCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class AwsService extends TransformerService{
  // public function uploadProfileImage($request, $user){
  //   if($request->hasFile('avatar')) {
	// 		$filenamewithextension = $request->file('avatar')->getClientOriginalName(); 	//get filename with extension
	// 		$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
	// 		$extension = $request->file('avatar')->getClientOriginalExtension(); //get file extension
	// 		$filenametostore = 'Users/Profiles/'.$filename.'_'.time().'.'.$extension;	//filename to store
	// 		Storage::disk('s3')->put($filenametostore, fopen($request->file('avatar'), 'r+'), 'public');	//Upload File to s3
	// 		$image_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
	// 		$user->avatar = $image_url;
	// 		return $user->save();
	// 	}
	// }
	public function uploadProfileImage($request, $object, $file_header, $bucketFolder){
    if($request->hasFile($file_header)) {
			$filenamewithextension = $request->file($file_header)->getClientOriginalName(); 	//get filename with extension
			$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
			$extension = $request->file($file_header)->getClientOriginalExtension(); //get file extension
			$filenametostore = $bucketFolder.$filename.'_'.time().'.'.$extension;	//filename to store
			Storage::disk('s3')->put($filenametostore, fopen($request->file($file_header), 'r+'), 'public');	//Upload File to s3
			$image_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
			if ($object instanceOf User)	{
				$object->avatar = $image_url;
			} else {
				$object->file = $image_url;
			}
			return $object->save();
		}
	}

	public function removeUpload($object, $remote_file, $bucketFolder) {
		$path = str_replace("https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/", '', $remote_file);
		Storage::disk('s3')->delete($path);
		if ($object instanceOf User)	{
			$object->avatar = '';
		} else {
			$object->file = '';
		}
		return $object->save();
	}
	// every service needs a transform function
  public function transform($badge){
    return [];
	}
}