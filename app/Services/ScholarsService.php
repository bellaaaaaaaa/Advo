<?php 

namespace App\Services;

use App\Scholar;
use App\User;
use Illuminate\Http\Request;

class ScholarsService extends TransformerService{

  protected $path = 'admin.scholars.';  

  public function all(Request $request){
    $sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$scholars = Scholar::orderBy($sort, $order);
		$listCount = $scholars->count();
		$scholars = $scholars->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($scholars), 'total' => $listCount]);
  }
  
  public function index(Request $request){
    if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($scholar){
		return [
			'id' => $scholar->id,
			'name' => $scholar->user->name,
			'email' => $scholar->user->email,
		];
	}
}