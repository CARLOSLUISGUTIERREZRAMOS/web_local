  <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="alert alert-success" role="alert">
                                <strong>Transacción exitosa!</strong><br>
                            </div>
                            <div class="accordion destinos--2" id="accordionStar">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne" aria-controls="collapseOne">
                                            <h3>Datos del Establecimiento:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <th>Nombre del Establecimiento:</th>
                                                                <td>Star Perú</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Teléfono</th>
                                                                <td>(511) 705-9000</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Dirección Comercial</th>
                                                                <td>Av. Comandante Espinar 331, Miraflores. Lima 18 - Perú</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Dominio</th>
                                                                <td>www.starperu.com</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingTwo">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h3>Datos de Pasajeros:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <thead>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th>Apellidos / Nombres</th>
                                                                <th>Boleto</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <?php
                                                            $pax = 1;
                                                            foreach ($data->TicketItemInfo as $row) {
                                                                ?>
                                                                <tr>
                                                                    <td>Pasajero <?= $pax ?></td>
                                                                    <td><?= $row->PassengerName->Surname . '  ' . $row->PassengerName->GivenName ?></td>
                                                                    <td><?= $row->attributes()->TicketNumber ?></td>
                                                                    <td><button type="button" class="btn btn-outline-danger btn_ver_ticket" id="<?= $row->attributes()->TicketNumber ?>">Ver Ticket</button></td>
                                                                </tr>
                                                                <?php
                                                                $pax++;
                                                            }
                                                            ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingThree">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                            <h3>Datos de la Compra:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar" style="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <th>Código de reserva:</th>
                                                                <td><?= $data_reserva->pnr ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Número de pedido:</th>
                                                                <td><?= $data_reserva->id ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Moneda:</th>
                                                                <td>USD</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Monto de la Transacción:</th>
                                                                <td><?= $data_reserva->total_pagar ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fecha y Hora del pedido:</th>
                                                                <td><?= (new DateTime($data_reserva->fecha_registro))->format('d/m/Y H:i') ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#TerminosCondiciones">Ver condiciones</button></td>
                                                                <!--<td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#PoliticasDevolucion">Politicas de devolución</button></td>-->
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>  
                    </div>
        </div>


<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 957770103;
var google_conversion_language = "es";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "Z_J_CLnhtgQQ99LZyAM";
var google_conversion_value = 120.00;
var google_conversion_currency = "USD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/957770103/?value=120.00&amp;currency_code=USD&amp;label=Z_J_CLnhtgQQ99LZyAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- Facebook Conversion Code for Compra -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6007309194922', {'value':'0.00','currency':'USD'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6007309194922&amp;cd[value]=0.00&amp;cd[currency]=USD&amp;noscript=1" /></noscript>


<!-- Analytics -->
<script> (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-32584975-1', 'auto'); ga('require', 'displayfeatures'); ga('send', 'pageview'); </script> 

<!-- Google Code for Star peru Junio Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 851657164;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "7NlcCMqlxnEQzIONlgM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/851657164/?label=7NlcCMqlxnEQzIONlgM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,­t,s)

{if(f.fbq)return;n=f­.fbq=function(){n.ca­llMethod?

n.callMethod.apply(n­,arguments):n.queue.­push(arguments)};

if(!f._fbq)f._fbq=n;­n.push=n;n.loaded=!0­;n.version='2.0';

n.queue=[];t=b.creat­eElement(e);t.async=­!0;

t.src=v;s=b.getEleme­ntsByTagName(e)[0];

s.parentNode.insertB­efore(t,s)}(window,d­ocument,'script',

'https://connect.face­book.net/en_US/fbeve­nts.js');

fbq('init', '7222225­11302954'); 

fbq('track', 'PageVi­ew');

</script>

<noscript>

<img height="1" widt­h="1" 

src="https://www.facebook­.com/tr?id=722222511­302954&ev=PageView

&noscript=1"/>

</noscript>