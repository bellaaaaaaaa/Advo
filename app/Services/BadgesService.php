<?php 

namespace App\Services;

use App\Badge;
use Illuminate\Http\Request;

class BadgesService extends TransformerService{

  protected $path = 'admin.badges.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$badges = Badge::orderBy($sort, $order);
		$listCount = $badges->count();
		$badges = $badges->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($badges), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($badge){
		return [
			'id' => $badge->id,
			'title' => $badge->title,
    ];
	}
}