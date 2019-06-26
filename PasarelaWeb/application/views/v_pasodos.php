<main class="contenidos">
    <div class="container">
        <?= form_open('PasoFinal') ?>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="accordion destinos--2" id="accordionStar">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <a class = "accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"  aria-controls="collapseOne">
                                <h3>Quienes viajan:</h3>
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar">
                            <?php
                            if ($cant_adl > 0) {
                                for ($i = 1; $i <= $cant_adl; $i++) {
                                    $data['pax_num'] = $i;
                                    $data['tipo_pax_cod'] = 'adl';
                                    $data['tipo_pax_name'] = 'Adulto';
                                    $data['paises'] = $paises;
                                    $this->load->view('bloques_pasodos/v_formulario_pax', $data);
                                }
                            }
                            if ($cant_chd > 0) {
                                for ($i = 1; $i <= $cant_chd; $i++) {
                                    $data['pax_num'] = $i;
                                    $data['tipo_pax_name'] = 'Niño';
                                    $data['tipo_pax_cod'] = 'chd';
                                    $this->load->view('bloques_pasodos/v_formulario_pax', $data);
                                }
                            }
                            if ($cant_inf > 0) {
                                for ($i = 1; $i <= $cant_inf; $i++) {
                                    $data['pax_num'] = $i;
                                    $data['tipo_pax_name'] = 'Infante';
                                    $data['tipo_pax_cod'] = 'inf';
                                    $this->load->view('bloques_pasodos/v_formulario_pax', $data);
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingThree">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <h3>¿Con quién nos contactamos?</h3>
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-10">
                                        <p>Estos datos son necesarios para enviar notificaciones y mensajes relacionados a tu compra, cambios en el vuelo u otros.</p>
                                    </div>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="form-group">
                                            <label for="e-mail">Correo electrónico:</label>
                                            <input type="text" class="form-control vacios" aria-describedby="e-mail" id="email" name="email" value="carlos5t@hotmail.com">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-10">
                                        <div class="form-group">
                                            <label for="e-mail2">Repetir correo electrónico:</label>
                                            <input type="text" class="form-control vacios " aria-describedby="e-mail2" id="email2" name="email_rep" value="carlos5t@hotmail.com">
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-sm-12 col-md-3">
                                        <label for="pre-loc">Prefijo país:</label>
                                        <div class="select">
                                            <select name="ddi_pais_tlfn">
                                                <?php foreach ($cod_ddi_paises->result() as $pais) { ?>
                                                    <option value="<?= $pais->ddi ?>" <?= ($pais->ddi == '+51') ? 'selected' : '' ?>><?= $pais->codigo_pais . ' ' . $pais->ddi ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="region">Región:</label>
                                            <input type="text" class="form-control" aria-describedby="region" id="region" name="region_tlfn" value="01">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="num-loc">Número local (fijo):</label>
                                            <input type="text" class="form-control" aria-describedby="num-loc" id="num-loc" name="num_tlfn" value="989149229">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <label>Prefijo país:</label>
                                        <div class="select">
                                            <select name="ddi_pais_cel">
                                                <?php foreach ($cod_ddi_paises->result() as $pais) { ?>
                                                    <option value="<?= $pais->ddi ?>" <?= ($pais->ddi == '+51') ? 'selected' : '' ?>><?= $pais->codigo_pais . ' ' . $pais->ddi ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="region2">Región:</label>
                                            <input type="text" class="form-control" aria-describedby="region2" id="region2" name="region_cel">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        <div class="form-group">
                                            <label for="num-loc2">Número local (celular):</label>
                                            <input type="text" class="form-control" aria-describedby="num-loc2" id="num-loc2" name="num_cel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingTwo">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h3>Desglose de precios:</h3>
                            </a>
                        </div>
                        <?= $v_desglose_precios ?>
                    </div>
                    <div class="card" id="accordionStar">
                        <div class="card-header" id="headingFour">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <h3>Forma de pago:</h3>
                            </a>
                        </div>
                        <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionStar">
                            <div class="card-body">

                                <?php $this->load->view('bloques_pasodos/v_desglose_tarjetas'); ?>

                                <div class="row">
                                    <div class="col-12">
                                        <br><p># Web Check-in No aplica para vuelos operados por Peruvian, acercarse 2 hrs antes al counter para hacer su check-in gracias. </p>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input vacios_radio"  type="checkbox" value="" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Acepto las condiciones de compra
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#TerminosCondiciones">Ver condiciones</button></td>
                                        <!--<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">ver condiciones</button>-->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"><br></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-8">
                                        <div class="form-check">
                                            <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck2">
                                            <label class="form-check-label" for="defaultCheck2">
                                                Acepto las condiciones de Transporte.
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <td><button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#ModalCondiciones_Transporte">Ver condiciones</button></td>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= $v_desglose_itinerario ?>
            <input type="hidden" name="cant_adl" value="<?= $cant_adl ?>">
            <input type="hidden" name="cant_chd" value="<?= $cant_chd ?>">
            <input type="hidden" name="cant_inf" value="<?= $cant_inf ?>">
            <input type="hidden" name="grupo_ida" value="<?= $grupo_ida ?>">
            <input type="hidden" name="grupo_retorno" value="<?= $grupo_retorno ?>">
            <input type="hidden" name="tipo_viaje" value="<?= $tipo_viaje ?>">
            <input type="hidden" name="cod_origen" value="<?= $cod_origen ?>">
            <input type="hidden" name="cod_destino" value="<?= $cod_destino ?>">
            <input type="hidden" name="geoip_pais" value="<?= $geoip_pais ?>">
            <input type="hidden" name="geoip_ciudad" value="<?= $geoip_ciudad ?>">
            <input type="hidden" id="TotalAplicaDesc" value="<?= $TotalAplicaDesc?>">
            
        </div>  
        <?= form_close() ?>
    </div>
</main>

<!--<script>
!function (f, b, e, v, n, t, s)
{
    if (f.fbq)
        return;
    n = f.fbq = function () {
        n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq)
        f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = '2.0';
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
}(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '1828446367243161');
fbq('track', 'PageView');

fbq('track', 'InitiateCheckout');

</script>
<noscript>
<img height="1" width="1" 
 src="https://www.facebook.com/tr?id=1828446367243161&ev=PageView
 &noscript=1"/>
</noscript>
End Facebook Pixel Code 
Analytics 
<script> (function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o), m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
ga('create', 'UA-32584975-1', 'auto');
ga('require', 'displayfeatures');
ga('send', 'pageview');</script> -->