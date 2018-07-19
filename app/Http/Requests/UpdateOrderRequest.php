<?php

namespace App\Http\Requests;

use App\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'status' => 'required|in:'. Order::STATUS_COMPLETE. ',' .Order::STATUS_CURRENT. ','. Order::STATUS_WAIT. ',' .Order::STATUS_CANCEL,
            'price' => 'nullable|numeric',
            'quantity' => 'nullable|numeric'
        ];
    }

    public function updateOrder(Order $order)
    {
        $this->isCompleteOrCancel($order);
        $this->onlyWaitOrderCanChangePrice($order);
        return tap($order, function($order) {
            $order->update($this->validated());
        });
    }

    private function isCompleteOrCancel(Order $order)
    {
        abort_if($order->status === Order::STATUS_COMPLETE
            || $order->status === Order::STATUS_WAIT, 422, 'No puedes cambiar el estado de un producto completado o cancelado');
    }

    private function onlyWaitOrderCanChangePrice(Order $order)
    {
        abort_if($order->status === Order::STATUS_CURRENT
            && (isset($this->validated()['price'])
                && $this->validated()['price'] !== null), 422, 'No puedes modificar el precio de una orden en proceso');
    }
}
