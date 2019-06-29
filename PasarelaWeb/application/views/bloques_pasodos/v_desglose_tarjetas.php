<div class="row">
    <div class="col-sm-12 col-md-6">
        <label for="pre-loc">Forma de pago:</label>
        <div class="select">
            <select id="select_cards" name="cc_code">
                <option value="TC_V">Visa</option>
                <option value="TC_M">Mastercard</option>
                <option value="TC_D">Diners Club</option>
                <option value="TC_A">American Express</option>
                <?php
                $RES = CantidadDeHorasPayPal($datetime_departure);
//                var_dump($mostrar_paypal);die;
                if ($RES === TRUE) {
                    ?>
                    <option value="PP">PayPal</option>
                    <?php
                }
                ?>
                <!--Bloque safetypay-->
                <option value="SP_C">Pago en Efectivo</option>
                <option value="SP_I">Banca por Internet</option>
                <option value="SP_E">Pagos Internacionales</option>
                <!--Bloque safetypay-->
                <option value="PE">Depósitos en efectivo</option>
                <option value="PEB">Transferencias Bancarias</option>
            </select>
            <div class="select__arrow"></div>
        </div>
    </div>


    
    <div class="col-sm-12 col-md-6">
        <div class="logo-medio-pago">
            <!--<img class="d-block w-70" id="img_cards" src="<?= base_url() ?>img/metodos_pagos/logo_pp.png" alt="First slide">-->
            <img class="d-block w-100" id="img_cards" src="<?= base_url() ?>img/metodos_pagos/logo_visa_opc2.png" alt="First slide">
        </div>
    </div>
    <label id="pagoefectivo"></label>
    <?=$html_desc?>
</div>