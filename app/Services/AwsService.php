<?php 

namespace App\Services;
use App\User;
use App\ReportCard;
use App\ScholarPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class AwsService extends TransformerService{
	public function uploadFile($request, $object, $file_header, $bucketFolder){
    if($request->hasFile($file_header)) {
			$filenamewithextension = $request->file($file_header)->getClientOriginalName(); 	//get filename with extension
			$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
			$extension = $request->file($file_header)->getClientOriginalExtension(); //get file extension
			$filenametostore = $bucketFolder.$filename.'_'.time().'.'.$extension;	//filename to store
			Storage::disk('s3')->put($filenametostore, fopen($request->file($file_header), 'r+'), 'public');	//Upload File to s3
			$image_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
			if ($object instanceOf User)	{
				$object->avatar = $image_url;
			} elseif ($object instanceOf ReportCard) {
				$object->file = $image_url;
			} else {
				$object->cover_image = $image_url;
			}
			return $object->save();
		}
	}

	public function removeUpload($object, $remote_file, $bucketFolder) {
		$path = str_replace("https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/", '', $remote_file);
		Storage::disk('s3')->delete($path);
		if ($object instanceOf User)	{
			$object->avatar = '';
		} elseif ($object instanceOf ReportCard) {
			$object->file = '';
		} elseif ($object instanceOf ScholarPost){
			$object->cover_image = '';
		} elseif ($object instanceOf Scholar){
			$object->school_file = '';
		}
		return $object->save();
	}
	public function upload($request, $requestFilePath, $remoteLocation){
		$filenamewithextension = $request->file($requestFilePath)->getClientOriginalName(); 	//get filename with extension
		$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
		$extension = $request->file($requestFilePath)->getClientOriginalExtension(); //get file extension
		$filenametostore =  $remoteLocation."/".$filename.'_'.time().'.'.$extension;	//filename to store
		Storage::disk('s3')->put($filenametostore, fopen($request->file($requestFilePath), 'r+'), 'public');	//Upload File to s3
		$url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
		return $url;
	}
	// every service needs a transform function
  public function transform($badge){
    return [];
	}
}