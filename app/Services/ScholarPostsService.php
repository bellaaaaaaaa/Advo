<?php 

namespace App\Services;

use App\ScholarPost;
use Illuminate\Http\Request;

class ScholarPostsService extends TransformerService{

  protected $path = 'admin.scholar_posts.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$scholarPosts = ScholarPost::orderBy($sort, $order);
		$listCount = $scholarPosts->count();
		$scholarPosts = $scholarPosts->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($scholarPosts), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($scholarPost){
		return [
			'id' => $scholarPost->id,
			'user_id' => $scholarPost->user_id,
			'title' => $scholarPost->title,
			'body' => $scholarPost->body,
			'likes' => count($scholarPost->scholar_post_likes()->get()),
			'comments' => count($scholarPost->scholar_post_comments()->get()),
		];
	}
}