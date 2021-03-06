@component('component.main')

    @slot('body_class', 'marketing')

    @slot('container', 'container-fluid')

    <!-- Masthead -->
    <header class="text-center">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5" style="color: #464240;">Sencillez a escala</h1>
                    <p class="start">
                        <b>{{ config()->get('app.name') }}</b> proporciona el punto de partida perfecto para que tu negocio crezca rápidamente.
                        Olvídate de la compra, mantenimiento y los altos costos de alojamiento de un sistema web y concéntrese en lo que realmente importa… ¡Tu negocio!
                    </p>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <a href="{{ url('/register') }}" class="btn btn-primary">Empezar</a>
                    <a href="{{ url('/search') }}" class="btn btn-outline-secondary">Explorar ahora</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center" style="border-top: 4px solid #e66761;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="fab fa-laravel m-auto text-primary text-danger"></i>
                        </div>
                        <h3>Laravel 5.6</h3>
                        <p class="lead mb-0">La version más reciente de Laravel, para aprovechar todas las excelentes funciones del framework.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="fab fa-vuejs m-auto text-primary text-success"></i>
                        </div>
                        <h3>Vue.js</h3>
                        <p class="lead mb-0">Interface de usuario, asombrosas.</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="fab fa-algolia m-auto text-primary"></i>
                        </div>
                        <h3>Algolia</h3>
                        <p class="lead mb-0">Encuentra lo que están buscando, con una búsqueda extremadamente rápida y muy relevante.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="showcase" style="border-top: 4px solid #e66761;">
        <div class="container-fluid p-0">
            <div class="row no-gutters">

                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/marketing1.png');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2 class="text-center">Encontrar Lo Que Buscas Siempre Será Fácil</h2>
                    <p class="lead mb-0">
                        Una búsqueda precisa con múltiples opciones, que hace que los usuarios encuentren lo que buscan con tan solo un retraso de ¡un milisegundo!
                    </p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/markting3.png');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2 class="text-center">Crea tu Negocio</h2>
                    <p class="lead mb-0">
                        Publica todos los productos y/o servicios que ofreces para llegar a más clientes que nunca.
                    </p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/marketing2.png');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Dashboard</h2>
                    <p class="lead mb-0">
                        Un tablero administrativo elegante y sencillo para administrar tu negocio y saber cómo se están desarrollando tus operaciones.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials text-center" style="border-top: 4px solid #e66761;">
        <div class="container">
            <h2 class="mb-5">Testimonios de usuarios</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgRMx2E8KtPle7fQQZs08bvrlI5sB_SAcGtMhWfVu3YyZNuFVd') }}" alt="">
                        <h5>Cristian Gómez</h5>
                        <p class="font-weight-light mb-0">"¡Esto es fantástico! Muchas gracias chicos!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{ asset('https://cf.ltkcdn.net/socialnetworking/images/std/168796-281x281-girl-swear-icon.png') }}" alt="">
                        <h5>Rosa Henriquez</h5>
                        <p class="font-weight-light mb-0">"{{ config()->get('app.name') }} es increíble, Lo he estado usando estas últimas semanas y le recomendé a mis amigos."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRETLsmFOlVNf6XJtNsPsdGpusnyaRa6xSwP7XOApi3rGmyIDjREQ') }}" alt="">
                        <h5>Patricia V.</h5>
                        <p class="font-weight-light mb-0">"¡Muchas gracias por poner a disposición de nosotros esta aplicacion con un plan gratuito!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @slot('scripts')
        <style>
            header {
                background: url('img/hero-illustration.svg');
                background-repeat: no-repeat,repeat-x;
                background-position: bottom;
                background-size: 1200px 609px;
                height: 800px;
                margin-bottom: -4px;
            }

            .start {
                color: #797572;
                font-size: 1.5rem;
                line-height: 1.5;
                font-family: Whitney SSm A,Whitney SSm B,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue;
            }
        </style>
    @endslot
@endcomponent
