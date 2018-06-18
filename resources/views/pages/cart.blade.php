@component('component.main')

    <shopping-cart inline-template
                  :articles="{{ json_encode($cart) }}">
        <div class="row">
            <div class="col-md-9">
                @component('component.card')
                    @slot('card_style', 'shadow-sm mb-5')

                    @slot('header', 'Carrito de Pedidos')

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
                                        <a href="" v-text="article.name"></a>
                                        <br>
                                        <small> <span v-text="article.status"></span> </small>
                                        <br>
                                        <button type="button" class="btn btn-link btn-sm" @click="removeArticleToCar(article)">Eliminar</button>
                                    </th>
                                    <th>@{{ article.price }}</th>
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
                    @slot('header', 'Articulos Favoritos')

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
                                                {{ $article->price }}
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

            </div>
        </div>
    </shopping-cart>

@endcomponent