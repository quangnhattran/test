<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Recaptcha;

class CreateThreadRequest extends FormRequest
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
    public function rules(Recaptcha $recaptcha)
    {
        //dd($recaptcha);
        return [
            'channel_id' => 'required',
            'title' => 'required|min:3',
            'body' => 'required|min:6',
            'g-recaptcha-response' => ['required',$recaptcha]
        ];
    }
}
