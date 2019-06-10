<?php 

namespace App\Services;

use App\User;
use Illuminate\Http\Request;

class UsersService extends TransformerService{

  protected $path = 'admin.users.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$users = User::orderBy($sort, $order);
		$listCount = $users->count();
		$users = $users->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($users), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($user){
		return [
			'id' => $user->id,
			'name' => $user->name,
			'email' => $user->email,
			'role' => $user->role > 0 ? ($user->role == 1 ? 'Benefactor' : 'Scholar') : 'Admin'
		];
	}
}