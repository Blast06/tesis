@component('component.main')

    <div class="row justify-content-center">
        <div class="col-md-8">

            @component('component.card')

                @slot('header')
                    Notificaciones
                    @if($notifications->count())
                        <small>
                            <a href="{{ url('notifications/read-all') }}">marcar todo como leido</a>
                        </small>
                    @endif
                @endslot

                @slot('header_style', 'bg-white font-weight-bold')

                @if($notifications->count())
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Tema</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>
                                <i class="{{  $notification->data['icon'] ?? 'icon' }}"></i>
                            </td>
                            <td>
                                <b>{{ $notification->data['subject'] ?? 'subject' }}</b>
                                <br>
                                {{ $notification->data['body'] ?? 'body' }}
                            </td>
                            <td>{{ $notification->created_at->diffForHumans() }}</td>
                            <td><a href="{{ url("notifications/{$notification->id}") }}">Marcar como leido</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                    <div class="alert alert-info" role="alert">
                        bandeja de notificación vacía
                    </div>
                @endif

            @endcomponent

        </div>
    </div>

@endcomponent