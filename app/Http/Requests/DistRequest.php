<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules['eff'] = 'required|integer|min:1';
        $rules['date_dist'] = 'required|date';
        foreach($this->request->get('kits') as $key => $kit){
            $rules['kits.'.$key.'.unite_dist'] = 'required|integer|min:1';
            $rules['kits.'.$key.'.qte_dist'] = 'integer|max:'.$kit['qte_st'];
        }
        
        return $rules;
    }

    public function messages(){
        $messages = [];
        $messages['eff.required'] = "Champ requis";
        $messages['eff.integer'] = "Doit être un entier";
        $messages['eff.min'] = "Minimum 1";

        foreach($this->request->get('kits') as $key => $kit){
            $messages['kits.'.$key.'.unite_dist.required'] = "Champ requis";//may not be greater than
            $messages['kits.'.$key.'.unite_dist.integer'] = "Doit être un entier";
            $messages['kits.'.$key.'.unite_dist.min'] = "Minimum 1";
            $messages['kits.'.$key.'.qte_dist.max'] = 'Maximum '.$kit['qte_st'];
        }

        return $messages;

    }
}
