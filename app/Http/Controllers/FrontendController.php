<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Productattribute;
use App\Models\Product;
use App\Models\productattributevalue;
use App\Models\Feeconfig;

class FrontendController extends Controller {

    public function index(Request $request){
        return view('frontend.index');
    }

    public function detail($id = 0, Request $request){
        $shipping_fee = 0;
        $item_price = 0;

        $listAttribute = Productattribute::where('pa_status', 1)->get()->toArray();
        if (count($listAttribute) > 0) {
            $listAttribute = array_column($listAttribute, null, 'pa_id');
        }
        
        $product = Product::where('p_id', $id)->first();
        if ($product === null) {
            abort(404, 'Không tìm thấy trang');
        }
        $product = $product->toArray();
        
        $product_attribute = productattributevalue::where('product_id', $id)->get()->toArray();
        if (count($product_attribute) > 0) {
            $product_attribute = array_column($product_attribute, null, 'pa_id');
        }

        $calc_fee = $this->calc_fee($listAttribute, $product_attribute);
        if (count($calc_fee) == 0) {
            die('something wrong, Fee product is zero, contact admin via email support@ggg_check.com');
        }

        $shipping_fee = max($calc_fee);

        $item_price = floatval($product['product_price']) + $shipping_fee;

        return view('frontend.detail', compact('listAttribute', 'product', 'product_attribute', 'shipping_fee', 'item_price'));
    }

    public function cart(Request $request){
        $listAttribute = Productattribute::where('pa_status', 1)->get()->toArray();
        if (count($listAttribute) > 0) {
            $listAttribute = array_column($listAttribute, null, 'pa_id');
        }

        return view('frontend.cart', compact('listAttribute'));
    }

    public function get_product(Request $request){
        $requestData = $request->all();

        if (!isset($requestData['url_search']) || $requestData['url_search'] == '' || $requestData['url_search'] == null) {
            return response()->json(['status' => 'false', 'message' => "Không được để trống đường dẫn"], 200);
        }

        // su dung file_get_contents thay vi CURL de bypass i'm not a robot cua amazon
        // $getcontent = file_get_contents($requestData['url_search']);

        // su dung guzzle tao request va header la tai khoan ca nhan de han che i'm not robot
        $response = Http::withHeaders([
            'cache-control' => 'no-cache',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
            'accept-encoding' => 'gzip, deflate, br',
            'accept-language' => 'en-US,en;q=0.9,vi;q=0.8',
            'cookie' => env('AMAZON_COOKIE'),
            'device-memory' => '8',
            'downlink' => '10',
            'dpr' => '1.25',
            'ect' => '4g',
            'pragma' => 'no-cache',
            'rtt' => '50',
            'sec-ch-device-memory' => '8',
            'sec-ch-dpr' => '1.25',
            'sec-ch-ua' => '"Chromium";v="112", "Google Chrome";v="112", "Not:A-Brand";v="99"',
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => '"Windows"',
            'sec-ch-ua-platform-version' => '"10.0.0"',
            'sec-ch-viewport-width' => '821',
            'sec-fetch-dest' => 'document',
            'sec-fetch-mode' => 'navigate',
            'sec-fetch-site' => 'same-origin',
            'sec-fetch-user' => '?1',
            'upgrade-insecure-requests' => '1',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
            'viewport-width' => '821'
        ])->timeout(6)->get($requestData['url_search']);

        if ($response->getStatusCode() != 200) {
            return response()->json(['status' => 'false', 'message' => 'Không thể kết nối đến website amazon, Vui lòng kiểm tra lại đường dẫn hoặc liên hệ với admin qua email : support@ggg_check.com'], 200);
        }
        
        $getcontent = $response->body();
        // check i'm not robot of amazon
        if (strpos($getcontent, "not a robot") !== false) {
            return response()->json(['status' => 'false', 'message' => "Request đến Amazon đang bị chặn bởi bộ lọc 'not a robot', Vui lòng thử lại sau!"], 200);
        }

        // get price
        $price_product = $this->getPrice($getcontent);
        if ($price_product == 0) {
            return response()->json(['status' => 'false', 'message' => 'Không tìm thấy giá của sản phẩm, Vui lòng kiểm tra lại đường dẫn hoặc liên hệ với admin qua email : support@ggg_check.com'], 200);
        }

        // get name
        $product_name = $this->getProductName($getcontent);
        if ($product_name == false) {
            return response()->json(['status' => 'false', 'message' => 'Không tìm thấy tên của sản phẩm, Vui lòng kiểm tra lại đường dẫn hoặc liên hệ với admin qua email : support@ggg_check.com'], 200);
        }

        // get attribute value
        $get_attribute = $this->getAttribute($getcontent);

        // not found one of attribute 
        if ($get_attribute == false) {
            response()->json(['status' => 'false', 'message' => 'Có giá trị không tìm thấy cho sản phẩm, Vui lòng kiểm tra lại đường dẫn hoặc liên hệ với admin qua email : support@ggg_check.com'], 200);
        }

        // $createData = array_merge($get_attribute, [
            
        // ]);
        
        $productCreate = Product::create([
            'product_url' => $requestData['url_search'],
            'product_name' => $product_name,
            'product_price' => $price_product,
        ]);
        
        foreach ($get_attribute as $key => $value) {
            $createEAV = Productattributevalue::create([
                'product_id' => $productCreate->p_id,
                'pa_id' => $key,
                'value' => $value
            ]);
        }

        return response()->json(['status' => 'true', 'id' => $productCreate->p_id], 200);
    }

    public function getPrice($htmlContent = ''){
        // get price
        $price_product = 0;

        // $getTablePrice = '/<table class="a-lineitem a-align-top">.*?<\/table>/s';
        // $getTablePrice = '/(?<=<div id="centerCol").*?(?=id="featurebullets_feature_div")/';
        $getTablePrice = '/(?<=<div id="ppd">).*?(?=<div id="hqpWrapper")/s';
        $getTablePriceContent = preg_match($getTablePrice, $htmlContent, $matches);
        if ($getTablePriceContent == 1) {
            $htmlContent = $matches[0];
        } else {
            // return vi khong tim duoc table chua price
            return $price_product;
        }
        
        // for normal price
        $regeNormalPrice = '/(?<=\<span\sclass="a-price\sa-text-price\sa-size-medium\sapexPriceToPay"\sdata-a-size="b"\sdata-a-color="price"><span\sclass="a-offscreen">\$)+[\d,]+\.[\d]+(?=<\/span><span)/';
        $getPriceNormal = preg_match($regeNormalPrice, $htmlContent, $matches);
        if ($getPriceNormal == 1) {
            $price_product = floatval($matches[0]);
        }

        // for sale price
        $regeSalePrice = '/<span\sclass="a-offscreen"[^>]*>\$([^<]*)<\/span>/';
        $getPriceSale = preg_match($regeSalePrice, $htmlContent, $matches);
        if ($getPriceSale == 1) {
            $price_product = floatval($matches[1]);
        }

        return $price_product;
    }

    public function getProductName($htmlContent = ''){
        // get price
        $product_name = '';

        $getProductName = '/<span id="productTitle"[^>]*>([^<]*)<\/span>/';
        $getProductNameContent = preg_match($getProductName, $htmlContent, $matches);
        if ($getProductNameContent == 1) {
            $product_name = trim($matches[1]);
        } else {
            // return vi khong tim duoc table chua price
            return false;
        }
        return $product_name;
    }

    public function getAttribute($getcontent = ''){
        $listAttribute = Productattribute::where('pa_status', 1)->get();
        $product_attribute_save = [];
        foreach ($listAttribute as $key => $value) {
            $resultData = '';
            $getAttributeRegex = $value->regular_exp;
            $resultRegex = preg_match($getAttributeRegex, $getcontent, $matches);
            if ($resultRegex == 1) {
                $resultData = $matches[$value->regular_exp_index];
            } else {
                return false;
            }

            // // convert weight Pounds to Grams
            // if ($value->pa_name == 'product_weight') {
            //     $resultData = floatval($resultData)*453.59237;
            // }

            $product_attribute_save[$value->pa_id] = $resultData;
        }
        return $product_attribute_save;
    }

    public function add_cart($id = 0){

        $productDetail = Product::where('p_id', $id)->first();
        if ($productDetail == null) {
            return response()->json(['status' => 'false', 'message' => 'not found product'], 200);
        }

        $listAttribute = Productattribute::where('pa_status', 1)->get()->toArray();
        if (count($listAttribute) > 0) {
            $listAttribute = array_column($listAttribute, null, 'pa_id');
        }
        
        $productAttributeValue = productattributevalue::where('product_id', $id)->get()->toArray();
        if (count($productAttributeValue) > 0) {
            $productAttributeValue = array_column($productAttributeValue, null, 'pa_id');
        }

        $calc_fee = $this->calc_fee($listAttribute, $productAttributeValue);
        if (count($calc_fee) == 0) {
            return response()->json(['status' => 'false', 'message' => 'something wrong, Fee product is zero, contact admin via email support@ggg_check.com'], 200);
        }


        if (session()->has('cart')) {
            $cart = session('cart');
        } else {
            $cart = [];
        }

        $shipping_fee = max($calc_fee);
        $cart[$productDetail->p_id] = [
            'product_id' => $productDetail->p_id,
            'product_detail' => $productDetail,
            'shipping_fee' => $shipping_fee,
            'item_price' => floatval($productDetail->product_price) + $shipping_fee,
            'attribute' => $productAttributeValue
        ];

        session(['cart' => $cart]);

        return response()->json(['status' => 'true', 'message' => 'success'], 200);
    }

    public function calc_fee($listAttribute, $productAttributeValue){
        $fee_calc = [];
        $fee_string = '';

        $list_fee = Feeconfig::where('fee_status', 1)->get()->toArray();
        if (count($list_fee) > 0) {
            $list_fee = array_column($list_fee, null, 'fee_id');
        }
        foreach ($list_fee as $key => $detail) {
            // check fee_config_condition first, if product equa, not need fee_config
            $decodeData = json_decode($detail['fee_config_condition'], true);
            if (
                $decodeData['attribute_select']  != '0' 
                && $decodeData['attribute_condition']  != '0' 
                && $decodeData['attribute_condition_value']  != null &&  $decodeData['attribute_condition_value']  != ''
                && $decodeData['config']  != null &&  $decodeData['config']  != ''
            ) {
                $fee_string = $decodeData['config'];
                foreach ($listAttribute as $key => $value) {
                    $fee_string = str_replace('|'.$value['pa_name'].'|', floatval($productAttributeValue[$value['pa_id']]['value']), $fee_string);
                }
                array_push($fee_calc, floatval(eval("return $fee_string;")));
                continue;
            }

            // if only fee_config 
            $fee_string = $detail['fee_config'];
            foreach ($listAttribute as $key => $value) {
                $fee_string = str_replace('|'.$value['pa_name'].'|', floatval($productAttributeValue[$value['pa_id']]['value']), $fee_string);
            }
            array_push($fee_calc, floatval(eval("return $fee_string;")));
        }
        return $fee_calc;
    }
}
