@component('component.main')

    <div class="row">

        <div class="col-md-12">

            @if(isset($breadcrumb_name) && isset($website))
                {{ Breadcrumbs::render($breadcrumb_name, $website) }}
            @endif

            @component('component.card')

                @slot('header')
                    {{ $header ?? "Datatables" }}
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                    <div class="table-responsive">
                        <table id="article" class="table table-striped" width='100%'>
                            <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Titulo</th>
                                <th>Precio</th>
                                <th>Categoria</th>
                                <th>Estado</th>
                                <th>Fecha de creacion</th>
                                <th>Fecha de actualizacion</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                            <tr>
                                <td>
                                    <img src="{{ $article->image_path }}" class="rounded" width="100" height="100">
                                </td>
                                <td>{{ $article->name }}</td>
                                <td>{{number_format($article->price,2,'.',',') }}</td>
                                <td>{{ $article->subCategory->name  }}</td>
                                <td>
                                    <span class="badge badge-pill badge-primary">
                                        {{$article->status }}
                                    </span>
                                </td>
                                <td>{{ $article->created_at->format('l j F Y') }}</td>
                                <td>{{ $article->updated_at->format('l j F Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href=""><i class="fas fa-image"> Imagenes</i></a>
                                        <a class="dropdown-item" href="{{ $article->url->edit }}"><i class="fas fa-edit"> Editar</i></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ $article->url->delete }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('{{ 'article-delete-'. $article->id  }}').submit();">
                                            <i class="fas fa-trash-alt"> Eliminar</i>
                                        </a>
                                        <form id="article-delete-{{ $article->id }}"
                                              action="{{ $article->url->delete }}"
                                              method="POST" style="display: none;">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $articles->links() }}
                @endcomponent
        </div>

    </div>
@endcomponent
