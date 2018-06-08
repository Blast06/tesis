@component('component.main')

   <div class="row">
       <div class="col-md-12">
           @component('component.card')
               @slot('header', 'Contactar con los sitios registrados')

               <message-create
                       :websites="{{ $websites }}">
               </message-create>

           @endcomponent
       </div>
   </div>

@endcomponent