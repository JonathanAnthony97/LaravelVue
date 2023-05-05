<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepartRequest extends FormRequest
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
        $rules['date'] = 'required|date';
        foreach($this->request->get('article') as $key => $ar){
            $rules['article.'.$key.'.sortie'] = 'required|integer|min:1|max:'.$ar['qte_st'];
        }
        return $rules;
    }

    public function messages(){
        $messages = [];
        foreach($this->request->get('article') as $key => $ar){
            $messages['article.'.$key.'.sortie.required'] = "Champ requis.";//may not be greater than
            $messages['article.'.$key.'.sortie.integer'] = "Doit être un entier.";
            $messages['article.'.$key.'.sortie.min'] = "Valeur minimum 1.";
            $messages['article.'.$key.'.sortie.max'] = "Valeur maximum ".$ar['qte_st'].".";
        }
        return $messages;
    }

}
