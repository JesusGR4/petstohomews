<?php
namespace App\Http\Requests\Users;
use App\Providers\CodesServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class LoginRequest  extends FormRequest
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
            "email"	            =>	    "required|email|max:50",
            "password"          =>      "required"
        ];
    }


    protected function formatErrors(Validator $validator)
    {
        return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
            'message' => $validator->errors()->all());
    }
}