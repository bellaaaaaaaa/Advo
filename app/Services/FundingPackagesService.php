<?php 

namespace App\Services;

use App\FundingPackage;
use Illuminate\Http\Request;

class FundingPackagesService extends TransformerService{

  protected $path = 'admin.funding_package.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$fundingPackages = FundingPackage::orderBy($sort, $order);
		$listCount = $fundingPackages->count();
		$fundingPackages = $fundingPackages->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($fundingPackages), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($fundingPackage){
		return [
			'id' => $fundingPackage->id,
			'title' => $fundingPackage->title,
			'description' => $fundingPackage->description,
			'body' => substr($fundingPackage->body, 0, 30).'...',
			'payment_method_type' => $fundingPackage->payment_method_type
		];
	}
}