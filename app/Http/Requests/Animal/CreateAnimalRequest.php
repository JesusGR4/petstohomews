<?php
namespace App\Http\Requests\Animal;
use App\Providers\CodesServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class CreateAnimalRequest extends FormRequest
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
            "name"	            =>	    "required",
            "breed"	            =>	    "required",
            "age"	            =>	    "required|min:1",
            "gender"	            =>	    "required",
            "medicalHistory"	            =>	    "required",
            "type"	            =>	    "required",

        ];
    }


    protected function formatErrors(Validator $validator)
    {

        $messages = array();
        foreach($validator->errors()->all() as $error){
            array_push($messages, trans($error));
        }

        return array('error' => true, 'code' => CodesServiceProvider::FAILED_VALIDATOR_CODE,
            'message' => $messages);
    }
}