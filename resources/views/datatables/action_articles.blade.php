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