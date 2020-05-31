<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticlePost extends FormRequest
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
            'name' => [ 
                    'regex:/^[\x{4e00}-\x{9fa5}\w]{2,50}$/u',
                    Rule::unique('article')->ignore(request()->id,'article_id'),
            ],
            'is_zy' => 'required',
            'is_show' => 'required',
            't_id' => 'required',
            
        ];
    }

    public function messages(){ 
        return [ 
            'name.regex' =>"文章标题可以由中文、数字、字母、下划线组成",
            'name.unique' =>'文章名称已存在',
            'is_zy.required' =>'文章重要性必填',
            'is_show.required' => '文章是否显示必填',
            't_id.required' => '文章分类必填',
        ]; 
    }



}
