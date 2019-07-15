<?php 

namespace App\Services;

use App\Benefactor;
use App\User;
use Illuminate\Http\Request;

class BenefactorsService extends TransformerService{

  protected $path = 'admin.benefactors.';  

  public function all(Request $request){
    $sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$benefactors = Benefactor::orderBy($sort, $order);
		$listCount = $benefactors->count();
		$benefactors = $benefactors->limit($limit)->offset($offset)->get();		
    return respond(['rows' => $this->transformCollection($benefactors), 'total' => $listCount]);
  }
  
  public function index(Request $request){
    if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($benefactor){
		return [
			'id' => $benefactor->id,
			'name' => $benefactor->user->name,
			'email' => $benefactor->user->email,
		];
	}
}