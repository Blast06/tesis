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

                    <ais-search-box></ais-search-box>

                    <ais-refinement-list attribute-name="sub_category"></ais-refinement-list>

                </div>

                <div class="col-md-9">
                    <ais-powered-by></ais-powered-by>

                    <ais-stats></ais-stats>

                    <ais-results>
                        <template slot-scope="{ result }">
                            <div class="card shadow-sm mb-5">
                                <div class="card-body">
                                    <div class="media">
                                        <img class="rounded img-fluid mr-2" :src="result.image_path">
                                        <div class="media-body">
                                            <h5 class="mt-0">
                                                <ais-highlight :result="result" attribute-name="name"></ais-highlight>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Última actualización <b>@{{ result.updated_at }}</b></small>
                                    <a href="#" class="card-link float-right">Ver mas</a>
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
                            'ais-pagination': 'pagination',
                            'ais-pagination__item': 'page-item',
                            'ais-pagination__item--active': 'active',
                            'ais-pagination__link': 'page-link',
                            }">
                    </ais-pagination>

                </div>
            </ais-index>
    </search-page>

@endcomponent
