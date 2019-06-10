<?php 

namespace App\Services;

use App\Interest;
use Illuminate\Http\Request;

class InterestsService extends TransformerService{

  protected $path = 'admin.interests.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$interests = Interest::orderBy($sort, $order);
		$listCount = $interests->count();
		$interests = $interests->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($interests), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($interest){
		return [
			'id' => $interest->id,
			'title' => $interest->title,
    ];
	}
}