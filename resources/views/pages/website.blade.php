@component('component.main')

    <search-page inline-template>
        <ais-index
                class="row"
                app-id="{{ config('scout.algolia.id') }}"
                api-key="{{ config('tesis.algolia.search_key') }}"
                index-name="websites">

            <div class="col-md-3">

                <ais-refinement-list attribute-name="location"
                                     :class-names="{
                                         'ais-refinement-list__count': 'badge badge-pill badge-primary',
                                         'ais-refinement-list__item': 'form-check',
                                         'ais-refinement-list__checkbox': 'form-check-input',
                                         }">
                    <h5 slot="header">
                        <i class="far fa-folder-open"></i>
                        UBICACION
                    </h5>
                </ais-refinement-list>

                <ais-refinement-list attribute-name="created_at"
                                     :class-names="{
                                         'ais-refinement-list__count': 'badge badge-pill badge-primary',
                                         'ais-refinement-list__item': 'form-check',
                                         'ais-refinement-list__checkbox': 'form-check-input',
                                         'ais-refinement-list': 'mt-5'
                                         }">
                    <h5 slot="header">
                        <i class="fas fa-calendar-alt"></i>
                        FECHA DE CREACION
                    </h5>
                </ais-refinement-list>
            </div>

            <div class="col-md-9">

                <ais-search-box>
                    <div class="input-group">
                        <ais-input
                                placeholder="Buscar Sitio..."
                                :class-names="{'ais-input': 'form-control'}">
                        </ais-input>

                        <span class="input-group-btn">
                                <ais-clear :class-names="{'ais-clear': 'btn btn-default'}">
                                    <i class="fas fa-times"></i>
                                </ais-clear>
                            </span>
                    </div>
                </ais-search-box>

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

                <ais-results class="row">
                    <template slot-scope="{ result }">
                        <div class="col-sm-4">
                            <div class="card shadow-sm mb-4">
                                <a :href="result.url_path">
                                    <img class="card-img-top" :src="result.image_path" :alt="result.name">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <ais-highlight :result="result" attribute-name="name"></ais-highlight>
                                    </h5>
                                    <p class="card-text"></p>
                                </div>
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