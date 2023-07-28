<?php

namespace App\Http\Controllers\Store;

use App\Models\StoreProduct;
use App\Models\MixingRack;
use App\Models\Mix;
use App\Models\MixDetail;
use App\Models\MixDetailTemp;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreTypeProduct;
use App\Models\StoreProductsIngredient;
use App\Models\InventoryRackPaintHistory;
use App\Models\InventoryRackPaint;

class MixController extends Controller {

    public function index() {
        $mix = Mix::all();
        return view('store.mix.index', compact('mix'));
    }

    public function create() {
        $product = StoreProduct::where('mix','1')->get();
		$bahan = StoreProduct::join('inventory_rack_paint as b', 'b.product_id', '=', 'store_products.id')->get();
		$typeProducts = StoreTypeProduct::all();
		$mixingRack = MixingRack::all();
        return view('store.mix.create', compact('product','bahan','typeProducts','mixingRack'));
    }

    public function store(Request $request) {
        $success = true;
        $message = "";

        $validateData = $request->validate([
            'date' => 'required',
            'rack_id' => 'required',
			'name' => 'required',
			'berat_jenis' => 'required',
			'qty' => 'required', 
			'um' => 'required',
			'description' => 'required'
        ]);

		
        $temp = MixDetailTemp::where('user_id', Auth::id())->get();
        if (count($temp) == 0) {
            $success = false;
            return Redirect::back()->withErrors(['msg' => 'List item not found']);
        }

        if ($success) {
            DB::beginTransaction();
            try {
                //save header
                $validateData['date'] = (!empty($request->date) ? date('Y-m-d', strtotime($request->date)) : NULL);
				$validateData['price'] = str_replace('Rp','',str_replace('.', '', $request['price']));
				$validateData['type_product_id'] = $request['type_product_id'];
				$validateData['status'] = 1;
				
                $mix = mix::create($validateData);

				// print_r($mix->qty);die;
				$type=0;
                //get temp
				$line = 1;

				$prd = StoreProduct::where('id',$request->product)->first();
				$new = false;
				if(!isset($prd)){
					$new = true;
					$prd = new StoreProduct();
					$prd->type_product_id = $request->type_product_id;
					$prd->barcode = $request->code;
					$prd->name = $request->name;
					$prd->hpp = $mix->price;
					$prd->margin_profit = 0;
					$prd->price = $mix->price;
					$prd->um = $request->um;
					$prd->berat_timbang = $request->berat_jenis;
					$prd->berat_jenis = $request->berat_jenis;
					$prd->berat_kemasan = 0;
					$prd->mix = 1;
					$saved = $prd->save();
					if (!$saved) {
						$success = false;
						$message = 'Failed save product';
					}
				}
				
				if($success){
                foreach ($temp as $row) {
					if($new && $success){
						$ing = new StoreProductsIngredient();
						$ing->id = $prd->id;
						$ing->line = $line;
						$ing->product_id = $row->product_id;
						$ing->weight = $row->weight;
						$ing->status = 1;
						$saved = $ing->save();
						if (!$saved) {
							$success = false;
							$message = 'Failed save ingredient';
						}
					}
					if($success){
						//detail
						$mixDetail = new MixDetail();
						$mixDetail->mix_id = $mix->id;
						$mixDetail->line = $line++;
						$mixDetail->product_id = $row->product_id;
						$mixDetail->weight = $row->weight;
						$saved = $mixDetail->save();
						if (!$saved) {
							$success = false;
							$message = 'Failed save detail';
						}
					}
					
					if($success){
						//history
						$inventoryHistory = new InventoryRackPaintHistory();
						$inventoryHistory->product_id = $row->product_id;
						$inventoryHistory->doc_id = $mix->id;
						$inventoryHistory->rack_id = $mix->rack_id;
						$inventoryHistory->weight_out = $row->weight;
						$inventoryHistory->weight_in = 0;
						
						$saved = $inventoryHistory->save();
						if (!$saved) {
							$success = false;
							$message = 'Failed save inventory rack';
						}
					}
					
					if($success){
						//stock
						$inventory = InventoryRackPaint::where(['product_id' => $row->product_id, 'rack_id' => $mix->rack_id])->first();
						if (!isset($inventory)) {
							$inventory = new InventoryRackPaint();
							$inventory->product_id = $row->product_id;
							$inventory->rack_id = $mix->rack_id;
							$inventory->weight = -1 * ($mix->qty * $row->weight);
						} else {
							$inventory->weight -= ($mix->qty * $row->weight);
						}
						if($inventory->weight < 0){
							$success = false;
							$message = "Stock ". $row->product->name ." tidak cukup";
						}else{
							$saved = $inventory->save();
							if (!$saved) {
								$success = false;
								$message = 'Failed save inventory product';
							}
						}
					}
					
                }
				}
                $deleted = MixDetailTemp::where('user_id', Auth::id())->delete();
                if (!$deleted) {
                    $success = false;
                    $message = 'Failed delete temp';
                }

                if ($success) {
                    DB::commit();
                }else{
					DB::rollback();
				}
            } catch (\Exception $e) {
                DB::rollback();
                $success = false;
                $message = $e->getMessage();
            }
        }

        if (!$success) {
            return redirect()->back()->withErrors(['msg' => $message]);
        }

        return redirect()->route('mix.index')->with('success', 'Mix added successfully.');
    }

	public function ingredient(){
		$prd = StoreProductsIngredient::where('id',$_POST['id'])->get();
		MixDetailTemp::where('user_id', Auth::id())->delete();
		foreach($prd as $v){
			$temp = new MixDetailTemp();
			$temp->user_id = Auth::id();
			
			$temp->product_id = $v->product_id;
			$temp->weight = $v->weight;
			$saved = $temp->save();
		}
		return ['success' => true];
	}
	
    public function show(Mix $mix) {
        return view('store.mix.show', compact('mix'));
    }

    public function detail() {
        $detailItem = MixDetailTemp::where('user_id', Auth::id())->get();
        return view('store.mix.detail', compact('detailItem'));
    }

    public function add() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = MixDetailTemp::where([
                        'user_id' => Auth::id(),
                        'product_id' => $request['product_id']
                    ])->first();
            if (!isset($temp)) {
                $temp = new MixDetailTemp();
                $temp->user_id = Auth::id();
				$temp->product_id = $request['product_id'];
				$temp->weight = 0;
			}
			$temp->weight = str_replace(',', '.', $request['qty']);
			$temp->save();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }
	
    public function delete() {
        $success = true;
        $message = '';
        $request = array_merge($_POST, $_GET);

        try {
            $temp = MixDetailTemp::findOrFail($request['id']);
            $temp->delete();
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return json_encode(['success' => $success, 'message' => $message]);
    }
}
