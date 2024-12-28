<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'store_id' => 'required|exists:stores,id',
            'date' => 'required|date|after:today',
            'time' => 'required|date_format:H:i',
            'people' => 'required|integer|min:1',
            'payment_method_id' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'store_id.required' => '店舗を選択してください。',
            'store_id.exists' => '選択した店舗が無効です。',
            'date.required' => '予約日を入力してください。',
            'date.date' => '有効な日付を入力してください。',
            'date.after' => '予約日は今日以降である必要があります。',
            'time.required' => '予約時間を入力してください。',
            'time.date_format' => '時間はHH:mm形式で入力してください。',
            'people.required' => '人数を入力してください。',
            'people.integer' => '人数は整数である必要があります。',
            'people.min' => '予約人数は1人以上である必要があります。',
            'payment_method_id.required' => '決済を完了してください。'
        ];
    }
}
