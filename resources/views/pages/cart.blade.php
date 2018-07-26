@component('component.main')

    <shopping-cart inline-template
                  :articles="{{ json_encode($cart) }}">
        <div class="row">
            <div class="col-md-9">
                @component('component.card')
                    @slot('card_style', 'shadow-sm mb-5')

                    @slot('header')
                        <h5 class="font-weight-bold text-center">Pedidos en el Carrito</h5>
                    @endslot

                        <div class="table-responsive"  v-if="items.length > 0">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="article in items">
                                    <th><img :src="article.image_path" class="rounded" width="100" height="100" /></th>
                                    <th>
                                        <a :href="'/articles/'+article.slug" v-text="article.name"></a>
                                        <br>
                                        <small> <span v-text="article.status"></span> </small>
                                        <br>
                                        <button type="button" class="btn btn-link btn-sm" @click="removeArticleToCar(article)">Eliminar</button>
                                    </th>
                                    <th v-if="article.status !== 'PRIVADO'">@{{ article.price | currency('RD$', 2, { spaceBetweenAmountAndSymbol: true }) }}</th>
                                    <th v-else>Sin expecificar</th>
                                    <th>
                                        <vue-numeric
                                                class="form-control"
                                                :class="[{ 'is-invalid' : errors.has('precio')  }]"
                                                separator=","
                                                name="quantity"
                                                v-bind:min="1"
                                                v-bind:max="100"
                                                v-model="article.pivot.quantity"
                                        ></vue-numeric>
                                        <br>
                                        <button class="btn-primary btn-sm" @click="quantityChange(article)">Actualizar</button>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    <div class="alert alert-info" role="alert" v-else>
                        No tienes articulos en el carrito
                    </div>
                @endcomponent

                @component('component.card')
                    @slot('header')
                        <h5 class="text-center font-weight-bold">Articulos Favoritos</h5>
                    @endslot

                    @if($favorites->count())
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Titulo</th>
                                    <th>Precio</th>
                                    <th>Estatus</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($favorites as $article)
                                    <tr>
                                        <th><img src="{{ $article->image_path }}" class="rounded" width="100" height="100" /></th>
                                        <td>
                                            <a href="{{ $article->url->show }}">
                                                {{ $article->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($article->status !== \App\Article::STATUS_PRIVATE)
                                                {{ number_format($article->price,2,'.',',') }}
                                                @else
                                                Sin expecificar
                                            @endif
                                        </td>
                                        <td>{{ $article->status }}</td>
                                        <td>{{ $article->stock ?? 'Sin especificar' }}</td>
                                        <td>
                                            <favorite-button
                                                    :favorited="{{ json_encode(auth()->user()->isFavoritedTo($article)) }}"
                                                    :article="{{ json_encode($article) }}">
                                            </favorite-button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            No tienes articulos en favoritos
                        </div>
                    @endif
                @endcomponent
            </div>
            <div class="col-md-3">
                @component('component.card')
                    @slot('header')
                        <h3 class="text-center font-weight-bold">Procesar Orden</h3>
                    @endslot

                    <h6><strong>Cantidad de articulos:</strong> @{{ itemsQuantity }}</h6>

                    <h6><strong>Sub Total:</strong> @{{ subtotal | currency('RD$', 2, { spaceBetweenAmountAndSymbol: true }) }}</h6>

                    <h6><strong>Iva:</strong> @{{ iva | currency('RD$', 2, { spaceBetweenAmountAndSymbol: true }) }}</h6>

                    <h6><strong>Total: </strong> @{{ total | currency('RD$', 2, { spaceBetweenAmountAndSymbol: true }) }}</h6>

                    <a @click="confirmOrder" class="btn btn-primary text-uppercase" :class="loading ? 'loader' : ''" v-show="itemsQuantity > 0">Ordenar ahora</a>
                @endcomponent
            </div>
        </div>
    </shopping-cart>

@endcomponent