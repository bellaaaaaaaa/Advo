<?php 

namespace App\Services;

use App\FundingTransaction;
use Illuminate\Http\Request;

class FundingTransactionsService extends TransformerService{

  protected $path = 'admin.funding_transactions.';  

  public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'id';
		$order = $request->order ? $request->order : 'desc';
		$limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';
		
		$fundingTransactions = FundingTransaction::orderBy($sort, $order);
		$listCount = $fundingTransactions->count();
		$fundingTransactions = $fundingTransactions->limit($limit)->offset($offset)->get();		
		return respond(['rows' => $this->transformCollection($fundingTransactions), 'total' => $listCount]);
  }
  
  public function index(Request $request){
		if ($request->wantsJson()) {
			return $this->all($request);
		}else{
			return view($this->path . 'index');
		}
	}
	
	public function transform($fundingTransaction){
		return [
			'id' => $fundingTransaction->id,
			'scholar_id' => $fundingTransaction->funding_target->user_id,
      'funding_target_id' => $fundingTransaction->funding_target->id,
      'amount' => ($fundingTransaction->amount_cents/100),
    ];
	}
}