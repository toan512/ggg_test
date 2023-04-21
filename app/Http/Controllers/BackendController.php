<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Productattribute;
use App\Models\Feeconfig;
use Validator;
use Illuminate\Validation\Rule;

class BackendController extends Controller {

    public function fee_manager(Request $request){
        $feeConfig = Feeconfig::where('fee_status', 1)->get();
        return view('backend.fee_index', compact('feeConfig'));
    }

    public function fee_detail($id = 0, Request $request){
        $feeConfig = Feeconfig::where('fee_id', $id)->first();
        if ($feeConfig === null) {
            abort(404, 'Không tìm thấy trang');
        }
        
        $productattribute = Productattribute::select('pa_name')->where([
            ['pa_status', '=', 1],
            ['pa_type', '=', 'number']
        ])->get()->toArray();

        if (count($productattribute) > 0) {
            $productattribute = array_column($productattribute, 'pa_name');
        }

        $productattributefull = Productattribute::select('pa_id', 'pa_name')->where([
            ['pa_status', '=', 1]
        ])->get()->toArray();

        return view('backend.fee_form', compact('feeConfig', 'productattribute', 'productattributefull'));
    }

    public function fee_update_process($id = 0, Request $request){
        $input = $request->all();

        $existFee = Feeconfig::where('fee_id', $id)->first();
        if ($existFee === null) {
            abort(404, 'Không tìm thấy trang');
        }

        // check validator
        $error_arr = $this->fee_validator($input);
        if (count($error_arr) > 0) {
            return redirect()->back()->withErrors($error_arr);
        }

        $input['fee_config_condition'] = json_encode($input['fee_config_condition_data']);
        $createconfig = $existFee->update($input);
        
        return redirect('fee_detail/'.$id.'')->with('success', ['Update success !']);
    }

    public function fee_create(Request $request){
        $productattribute = Productattribute::select('pa_name')->where([
            ['pa_status', '=', 1],
            ['pa_type', '=', 'number']
        ])->get()->toArray();

        if (count($productattribute) > 0) {
            $productattribute = array_column($productattribute, 'pa_name');
        }

        $productattributefull = Productattribute::select('pa_id', 'pa_name')->where([
            ['pa_status', '=', 1]
        ])->get()->toArray();

        $feeConfig = new Feeconfig;
        return view('backend.fee_form', compact('feeConfig', 'productattribute', 'productattributefull'));
    }

    public function fee_create_process(Request $request){
        $input = $request->all();

        // check validator
        $error_arr = $this->fee_validator($input);
        if (count($error_arr) > 0) {
            return redirect()->back()->withErrors($error_arr);
        }

        $input['fee_config_condition'] = json_encode($input['fee_config_condition_data']);
        $createconfig = Feeconfig::create($input);
        
        return redirect('fee_detail/'.$createconfig->fee_id.'')->with('success', ['Create success !']);
    }

    public function fee_validator($input){
        $error_arr = [];

        if (!isset($input['fee_name']) || $input['fee_name'] == null || $input['fee_name'] == '') {
            array_push($error_arr, 'Fee name empty!');
        }
        if (isset($input['fee_config_condition_data']['config']) && $input['fee_config_condition_data']['config'] != '' && preg_match('/[^a-z0-9\|\_\+\-\*\(\)\.\/ ]+/', $input['fee_config_condition_data']['config'], $matches) == 1) {
            array_push($error_arr, 'Fee Config condition only support |attribute_name|, number, + - * / and space');
        }
        if (isset($input['fee_config']) && $input['fee_config'] != '' && preg_match('/[^a-z0-9\|\_\+\-\*\(\)\.\/ ]+/', $input['fee_config'], $matches) == 1) {
            array_push($error_arr, 'Fee Config only support |attribute_name|, number, + - * / ( ) . and space');
        }

        return $error_arr;
    }


    public function attribute_manager(Request $request){
        $productattribute = Productattribute::where('pa_status', 1)->get();
        return view('backend.attribute_index', compact('productattribute'));
    }

    public function attribute_detail($id = 0, Request $request){
        $productattribute = Productattribute::where('pa_id', $id)->first();
        if ($productattribute === null) {
            abort(404, 'Không tìm thấy trang');
        }
        return view('backend.attribute_form', compact('productattribute'));
    }

    public function attribute_update_process($id = 0, Request $request){
        $input = $request->all();

        $productattribute = Productattribute::where('pa_id', $id)->first();
        if ($productattribute === null) {
            abort(404, 'Không tìm thấy trang');
        }

        $attribute_validator = $this->attribute_validator($input, $id);
        if ($attribute_validator !== true) {
            // return redirect('attribute_create')->withErrors($attribute_validator->errors());
            return redirect()->back()->withErrors($attribute_validator->errors());
        }
        $productattribute->fill($input);
        $productattribute->update();

        return redirect('attribute_detail/'.$id.'')->with('success', ['Update success!']);
    }

    public function attribute_create(Request $request){
        $productattribute = new Productattribute;
        return view('backend.attribute_form', compact('productattribute'));
    }

    public function attribute_create_process(Request $request){
        $input = $request->all();
        $productattribute = new Productattribute;

        $attribute_validator = $this->attribute_validator($input);
        if ($attribute_validator !== true) {
            // return redirect('attribute_create')->withErrors($attribute_validator->errors());
            return redirect()->back()->withErrors($attribute_validator->errors());
        }
        $productattribute = Productattribute::create($input);
        
        return redirect('attribute_detail/'.$productattribute->pa_id.'')->with('success', ['Create success !']);
    }

    public function attribute_remove($id = 0, Request $request) {
        $detail = Productattribute::where('pa_id', $id)->first();
        if ($detail) {
            $detail->pa_status = 0;
            $detail->save();
            return redirect()->back()->with('success', ['Xóa dữ liệu thành công!']);
        }
        return redirect()->back()->withErrors(['Không tìm thấy dữ liệu']);
    }

    public function attribute_validator($input, $id = 0) {
        $messages = [
            'pa_text_show.required' => 'Product Attribute Text not empty',
            'pa_name.required' => 'Product Attribute Name not empty',
            'pa_name.unique' => 'Product Attribute Name is exist',
            'pa_name.not_regex' => 'Product Attribute Name Only letter normal a-z and character _',
            'regular_exp.required' => 'Regular expression not empty',
            'regular_exp_index.required' => 'Regular expression index not empty',
            'regular_exp_index.not_regex' => 'Regular expression index only number',
            'pa_type.required' => 'Attribute Value Type not empty'
        ];

        $rule = [
            'pa_text_show' => 'required',
            'pa_name' => 'required|unique:tbl_product_attributes|not_regex:/[^a-z\_]+/',
            'regular_exp' => 'required',
            'regular_exp_index' => 'required|not_regex:/[^0-9]+/',
            'pa_type' => 'required'
        ];
        if ($id != 0) {
            $rule['pa_name'] = ['required', Rule::unique('tbl_product_attributes')->ignore($id, 'pa_id'),'not_regex:/[^a-z\_]+/'];
        }

        $validation = Validator::make($input, $rule, $messages);

        if ($validation->fails()) {
            // return redirect()->back()->withErrors($validation->errors());
            return $validation;
        }

        return true;
    }
}
