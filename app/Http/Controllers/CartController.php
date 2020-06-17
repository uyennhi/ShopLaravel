<?php

namespace App\Http\Controllers;


use App\Cart_model;
use App\ProductAtrr_model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    //
    public function index(){
        $session_id=Session::get('session_id');
        $cart_datas=Cart_model::where('session_id',$session_id)->get();
        $total_price=0;
        foreach ($cart_datas as $cart_data){
            $total_price+=$cart_data->price*$cart_data->quantity;
        }
        return view('frontEnd.cart',compact('cart_datas','total_price'));
    }

    public function addToCart(Request $request){
        $inputToCart=$request->all();
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        if($inputToCart['size']==""){
            return back()->with('message','Please select Size');
        }else{
            $stockAvailable=DB::table('product_att')->select('stock','sku')->where(['products_id'=>$inputToCart['products_id'],
                'price'=>$inputToCart['price']])->first();
            if($stockAvailable->stock>=$inputToCart['quantity']){
                $session_id=Session::get('session_id');
                if(empty($session_id)){
                    $session_id=Str::random(40);
                    Session::put('session_id',$session_id);
                }
                $inputToCart['session_id']=$session_id;
                $sizeAtrr=explode("-",$inputToCart['size']);
                $inputToCart['size']=$sizeAtrr[1];
                $inputToCart['product_code']=$stockAvailable->sku;
                
                $count_duplicateItems=Cart_model::where(['products_id'=>$inputToCart['products_id'],
                    'product_color'=>$inputToCart['product_color'],
                    'size'=>$inputToCart['size'],'session_id'=>$inputToCart['session_id']])->count();
                if($count_duplicateItems>0){
                    $quanity_duplicateItems=Cart_model::select('quantity')->where(['products_id'=>$inputToCart['products_id'],
                    'product_color'=>$inputToCart['product_color'],
                    'size'=>$inputToCart['size'],'session_id'=>$inputToCart['session_id']])->first();

                    if($stockAvailable->stock >= $quanity_duplicateItems->quantity + $inputToCart['quantity']){
                        $duplicateItems=Cart_model::where(['products_id'=>$inputToCart['products_id'],
                        'product_color'=>$inputToCart['product_color'],
                        'size'=>$inputToCart['size'],'session_id'=>$inputToCart['session_id']])->increment('quantity',$inputToCart['quantity']);
                    
                        return back()->with('message','Sản phẩm đã có trong giỏ hàng. Hệ thống đã cập nhật số lượng');
                    }else{
                        return back()->with('message','Sản phẩm đã có trong giỏ hàng. Số lượng trong kho không đủ.');
                    }
                }else{
                    Cart_model::create($inputToCart);
                    return back()->with('message','Đã thêm vào giỏ hàng');
                }
               
                
            }else{
                return back()->with('message','Hàng Không đủ vui lòng chọn lại.');
            }
        }
    }

    public function updateQuantity($id,$quantity){
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $sku_size=DB::table('cart')->select('product_code','size','quantity')->where('id',$id)->first();
        $stockAvailable=DB::table('product_att')->select('stock')->where(['sku'=>$sku_size->product_code,
            'size'=>$sku_size->size])->first();
        $updated_quantity=$sku_size->quantity+$quantity;
        if($stockAvailable->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity);
            return back()->with('message','Update Quantity already');
        }else{
            return back()->with('message','Stock is not Available!');
        }


    }

    public function updatettQuantity(Request $request ){
        $data = $request->all();
        $id = $data['idqtt'];
        echo $id;
        
        $quantity = $data['qtt'];
        echo $quantity;
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $sku_size=DB::table('cart')->select('product_code','size','quantity')->where('id',$id)->first();
        $stockAvailable=DB::table('product_att')->select('stock')->where(['sku'=>$sku_size->product_code,
            'size'=>$sku_size->size])->first();
        $updated_quantity=$quantity;
        echo $quantity;
        if($stockAvailable->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->update([
                'quantity' => $quantity
             ]);
             $session_id=Session::get('session_id');
            $cart_datas=Cart_model::where('session_id',$session_id)->get();
            $total_price=0;
            foreach ($cart_datas as $cart_data){
                $total_price+=$cart_data->price*$cart_data->quantity;
            }
            return view('frontEnd.cart',compact('cart_datas','total_price'));
        }else{
            return back()->with('message','Stock is not Available!');
        }


    }


   

    public function deleteItem($id=null){
        $delete_item=Cart_model::findOrFail($id);
        Session::forget('discount_amount_price');
        Session::forget('coupon_code');
        $delete_item->delete();
        return back()->with('message','Deleted Success!');
    }
}
