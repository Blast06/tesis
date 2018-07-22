@component('component.main')

    <section class="pricing-table">
        <div class="container">
            <div class="block-heading">
                <h2>Pricing Table</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis vitae leo.</p>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-5 col-lg-3">
                    <div class="item">
                        <div class="heading">
                            <h3>COMUNIDAD</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="features">
                            <h4><span class="feature">Full Support</span> : <span class="value">No</span></h4>
                            <h4><span class="feature">Duration</span> : <span class="value">30 Days</span></h4>
                            <h4><span class="feature">Storage</span> : <span class="value">10GB</span></h4>
                        </div>
                        <div class="price">
                            <h4>GRATIS</h4>
                        </div>
                        <button class="btn btn-block btn-outline-primary" type="submit">COMENZAR AHORA</button>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3">
                    <div class="item">
                        <div class="ribbon">Best Value</div>
                        <div class="heading">
                            <h3>ESENCIAL</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="features">
                            <h4><span class="feature">Full Support</span> : <span class="value">Yes</span></h4>
                            <h4><span class="feature">Duration</span> : <span class="value">60 Days</span></h4>
                            <h4><span class="feature">Storage</span> : <span class="value">50GB</span></h4>
                        </div>
                        <div class="price">
                            <h4>$25</h4>
                        </div>
                        <button class="btn btn-block btn-primary" type="submit">BUY NOW</button>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3">
                    <div class="item">
                        <div class="heading">
                            <h3>PREMIUM</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="features">
                            <h4><span class="feature">Full Support</span> : <span class="value">Yes</span></h4>
                            <h4><span class="feature">Duration</span> : <span class="value">120 Days</span></h4>
                            <h4><span class="feature">Storage</span> : <span class="value">150GB</span></h4>
                        </div>
                        <div class="price">
                            <h4>$75</h4>
                        </div>
                        <button class="btn btn-block btn-outline-primary" type="submit">BUY NOW</button>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3">
                    <div class="item">
                        <div class="heading">
                            <h3>PLUS</h3>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="features">
                            <h4><span class="feature">Full Support</span> : <span class="value">Yes</span></h4>
                            <h4><span class="feature">Duration</span> : <span class="value">120 Days</span></h4>
                            <h4><span class="feature">Storage</span> : <span class="value">150GB</span></h4>
                        </div>
                        <div class="price">
                            <h4>$100</h4>
                        </div>
                        <button class="btn btn-block btn-outline-primary" type="submit">BUY NOW</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @slot('scripts')
        <style>
            @import url("https://fonts.googleapis.com/css?family=Montserrat");

            .pricing-table{
                font-family: 'Montserrat', sans-serif;
            }

            .pricing-table .block-heading {
                padding-top: 80px;
                margin-bottom: 40px;
                text-align: center;
            }

            .pricing-table .block-heading h2 {
                color:#3b99e0;
            }

            .pricing-table .block-heading p {
                text-align: center;
                max-width: 420px;
                margin: auto;
                opacity: 0.7;
            }

            .pricing-table .heading {
                text-align: center;
                padding-bottom: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .pricing-table .item {
                background-color: #ffffff;
                box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
                border-top: 2px solid #5ea4f3;
                padding: 30px;
                overflow: hidden;
                position: relative;
            }

            .pricing-table .col-md-5:not(:last-child) .item {
                margin-bottom: 30px;
            }

            .pricing-table .item button {
                font-weight: 600;
            }

            .pricing-table .ribbon {
                width: 160px;
                height: 32px;
                font-size: 12px;
                text-align: center;
                color: #fff;
                font-weight: bold;
                box-shadow: 0px 2px 3px rgba(136, 136, 136, 0.25);
                background: #4dbe3b;
                transform: rotate(45deg);
                position: absolute;
                right: -42px;
                top: 20px;
                padding-top: 7px;
            }

            .pricing-table .item p {
                text-align: center;
                margin-top: 20px;
                opacity: 0.7;
            }

            .pricing-table .features .feature {
                font-weight: 600; }

            .pricing-table .features h4 {
                text-align: center;
                font-size: 18px;
                padding: 5px;
            }

            .pricing-table .price h4 {
                margin: 15px 0;
                font-size: 45px;
                text-align: center;
                color: #2288f9;
            }

            .pricing-table .buy-now button {
                text-align: center;
                margin: auto;
                font-weight: 600;
                padding: 9px 0;
            }
        </style>
    @endslot

@endcomponent