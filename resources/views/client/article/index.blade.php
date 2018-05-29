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
                                    <a class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </a>
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