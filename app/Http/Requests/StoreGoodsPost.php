<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGoodsPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'goods_name' => 'regex:/^[\x{4e00}-\x{9fa5}\w]{2,50}$/u|required|unique:goods', 
            'goods_name' => [ 
                    'regex:/^[\x{4e00}-\x{9fa5}\w]{2,50}$/u',
                    Rule::unique('goods')->ignore(request()->id,'goods_id'),
            ],
            'cate_id' => 'required', 
            'brand_id' => 'required',
            'goods_num' => 'required|numeric|max:99999999|min:0',
            'goods_sn' => 'required',
            'goods_price' => 'required|numeric',
        ];
    }


    public function messages(){ 
        return [ 
            'goods_name.regex' =>"商品名称可以包含中文、数字、字母、下划线且唯一，长度范围2-50位",
            'goods_name.unique' =>'商品名称已存在',
            'cate_id.required' =>'商品分类必填',
            'brand_id.required' => '商品品牌必填',
            'goods_num.required' => '商品库存必填',
            'goods_num.max' => '商品库存不超过千万',
            'goods_num.numeric' => '商品库存必须是数字',
            'goods_sn.required' => '商品货号必填',
            'goods_price.required' => '商品价格必填',
            'goods_price.numeric' => '商品价格必须数字',
        ]; 
    }


}
