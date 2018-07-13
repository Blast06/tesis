<?php

namespace App\Http\Requests;

use App\Article;
use App\Events\ArticleUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    private $orders = [];

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
            'orders' => 'required|array'
        ];
    }

    /**
     * @return mixed
     */
    public function createOrders()
    {
        foreach ($this->validated()['orders'] as $order) {
            $this->arrayCompliesWithTheRules($order);
            $this->verifyTheOrder($this->getArticleInstace($order['article_id']), $order['quantity']);
        }

        DB::transaction(function (){
            foreach ($this->validated()['orders'] as $order) {
                $article = $this->getArticleInstace($order['article_id']);
                $this->changeStock($article, $order['quantity']);
                array_push($this->orders, $this->createOrder($article, $order['quantity']));
            }
        });

        return $this->orders;
    }

    /**
     * @param $order
     */
    private function arrayCompliesWithTheRules($order)
    {
        abort_unless(property_exists((object) $order, 'article_id')
            && property_exists((object) $order, 'quantity'), 422, 'el array con las ordenes no comple con las reglas establecidas');
    }

    /**
     * @param \App\Article $article
     * @param $quantity
     */
    private function verifyTheOrder(Article $article, $quantity)
    {
        abort_if($article->status === Article::STATUS_NOT_AVAILABLE, 422, "El articulo {$article->name} no esta disponible");
        abort_if($article->stock !== null
            && $article->stock < $quantity, 422, "El articulo {$article->name} no tiene stock [{$quantity}] suficiente para la el pedido");
    }

    /**
     * @param $article_id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function getArticleInstace($article_id)
    {
        return Article::findOrFail($article_id);
    }

    /**
     * @param \App\Article $article
     * @param $quantity
     */
    private function changeStock(Article $article, $quantity): void
    {
        if ($article->stock !== null) {
            $article->stock -= $quantity;
            $article->save();
            event(New ArticleUpdate($article));
        }
    }

    /**
     * @param \App\Article $article
     * @param $quantity
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function createOrder(Article $article, $quantity)
    {
        return $article->orders()->create([
            'quantity' => $quantity,
            'price' => $article->status !== Article::STATUS_PRIVATE ? (int) $article->price : null,
            'user_id' => auth()->id(),
            'website_id' => $article->website->id
        ]);
    }
}
