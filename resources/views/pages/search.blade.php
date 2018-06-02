@component('component.main')

    <search-page inline-template>
            <ais-index
                    class="row"
                    app-id="{{ config('scout.algolia.id') }}"
                    api-key="{{ config('tesis.algolia.search_key') }}"
                    index-name="articles">

                <div class="col-md-3">
                    <ais-index :query="'{{ request()->q ?? "" }}'">

                    </ais-index>

                    <ais-refinement-list attribute-name="sub_category"
                                         :class-names="{
                                         'ais-refinement-list__count': 'badge badge-pill badge-primary',
                                         'ais-refinement-list__item': 'form-check',
                                         'ais-refinement-list__checkbox': 'form-check-input',
                                         }">
                        <h5 slot="header">
                            <i class="far fa-folder-open"></i>
                            CATEGORIA
                        </h5>
                    </ais-refinement-list>

                </div>

                <div class="col-md-9">

                    <ais-search-box>
                        <div class="input-group">
                            <ais-input
                                    placeholder="Buscar articulo..."
                                    :class-names="{'ais-input': 'form-control'}">
                            </ais-input>

                            <span class="input-group-btn">
                                <ais-clear :class-names="{'ais-clear': 'btn btn-default'}">
                                    <i class="fas fa-times"></i>
                                </ais-clear>
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ais-powered-by></ais-powered-by>

                                <ais-stats>
                                    <template slot-scope="{ totalResults, processingTime, query, resultStart, resultEnd }">
                                        @{{ totalResults }} encontrados en @{{ processingTime }}ms
                                    </template>
                                </ais-stats>
                            </div>
                        </div>


                    <ais-results>
                        <template slot-scope="{ result }">
                            <div class="card shadow-sm mb-5">
                                <div class="card-body">
                                    <div class="media">
                                        <a :href="result.url_path">
                                            <img class="rounded img-fluid mr-2" :src="result.image_path">
                                        </a>
                                        <div class="media-body">
                                            <h5 class="mt-0">
                                                <ais-highlight :result="result" attribute-name="name"></ais-highlight>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Última actualización <b>@{{ result.updated_at }}</b></small>
                                    <a :href="result.url_path" class="card-link float-right">Ver mas</a>
                                </div>
                            </div>
                        </template>
                    </ais-results>

                    <ais-no-results>
                        <template slot-scope="props">
                            Ningún resultado coincide con su consulta <b>@{{ props.query }}</b>.
                        </template>
                    </ais-no-results>

                    <ais-pagination
                            :class-names="{
                            'ais-pagination': 'pagination justify-content-center',
                            'ais-pagination__item': 'page-item',
                            'ais-pagination__item--active': 'active',
                            'ais-pagination__link': 'page-link',
                            'ais-pagination__item--disabled': 'disabled',
                            }">
                        <template slot="first">Primera página</template>
                        <template slot="previous">Anterior</template>
                        <template slot="next">Siguiente</template>
                        <template slot="last">Ultima pagina</template>
                    </ais-pagination>

                </div>
            </ais-index>
    </search-page>

@endcomponent
