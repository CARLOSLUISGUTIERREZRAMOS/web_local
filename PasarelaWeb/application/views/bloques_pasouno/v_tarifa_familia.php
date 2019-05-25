<?php 
$tarifa_promo = (isset($DataVuelo->PROMO->Tarifa)) ? TRUE : FALSE; 
$tarifa_basica = (isset($DataVuelo->BASICA->Tarifa)) ? TRUE : FALSE; 
$tarifa_regular = (isset($DataVuelo->REGULAR->Tarifa)) ? TRUE : FALSE; 
$tarifa_premium = (isset($DataVuelo->PREMIUM->Tarifa)) ? TRUE : FALSE; 

if($tarifa_promo && ($DataVuelo->ResBookDesigQuantity >= $CanTotalPax)){ ?>
    <td>
    <div class="form-check">
        <label class="form-check-label" for="exampleRadios1">
            <input class="form-check-input uno uno" type="radio" name="grupo_<?=$TipoVuelo?>" id="chk_tarifa" value="<?= $DataVuelo->PROMO->Tarifa."|".$DataVuelo->PROMO->Clase."|".$key."|".$ArrivalDateTime."|".$DepartureDateTime?>">
            <span class="tarifa_<?=$TipoVuelo?>"><?= $DataVuelo->PROMO->Tarifa?></span>
            <span class="infomas">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$DataVuelo->ResBookDesigQuantity?> últimos asientos <br> <b>Condiciones</b></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        Tarifa valida sólo para viajes Ida y Vuelta <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima 6 meses <br>
                        <div class="dropdown-divider"></div>
                        Niños entre 2 y 11 años: 33% de descuento <br>
                        <div class="dropdown-divider"></div>
                        Infantes entre 0 y 2 años sin ocupar asiento: sin cargos. <br>
                        <div class="dropdown-divider"></div>
                        Cambios por vuelo/fecha/endosos dentro de las 24 horas a la salida del vuelo USD 15 + IGV. <br>
                        <div class="dropdown-divider"></div>
                        ver más en Paso 3. <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima: sin restricción.
                    </div>
                </div>
            </span>
        </label>
    </div>
</td>
    
<?php
}else{ ?>
    <td><div class='form-check'></div></td>
    <?php 
}

if($tarifa_basica){ ?>
    <td>
    <div class="form-check">
        <label class="form-check-label" for="exampleRadios1">
            <input class="form-check-input uno uno" type="radio" name="grupo_<?=$TipoVuelo?>" id="chk_tarifa" value="<?=$DataVuelo->BASICA->Tarifa.'|'.$DataVuelo->BASICA->Clase."|".$key."|".$ArrivalDateTime."|".$DepartureDateTime.'|SI' ?>">
            <span class="tarifa_<?=$TipoVuelo?>"><?= $DataVuelo->BASICA->Tarifa ?></span>
            <span class="infomas">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$DataVuelo->ResBookDesigQuantity?> últimos asientos <br> <b>Condiciones</b></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        Tarifa valida sólo para viajes Ida y Vuelta <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima 6 meses <br>
                        <div class="dropdown-divider"></div>
                        Niños entre 2 y 11 años: 33% de descuento <br>
                        <div class="dropdown-divider"></div>
                        Infantes entre 0 y 2 años sin ocupar asiento: sin cargos. <br>
                        <div class="dropdown-divider"></div>
                        Cambios por vuelo/fecha/endosos dentro de las 24 horas a la salida del vuelo USD 15 + IGV. <br>
                        <div class="dropdown-divider"></div>
                        ver más en Paso 3. <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima: sin restricción.
                    </div>
                </div>
            </span>
        </label>
    </div>
</td>
    
<?php
}else{ ?>
    <td><div class='form-check'></div></td>
    <?php 
}

if($tarifa_regular){ ?>
    <td>
    <div class="form-check">
        <label class="form-check-label" for="exampleRadios1">
            <input class="form-check-input uno uno" type="radio" name="grupo_<?=$TipoVuelo?>" id="chk_tarifa" value="<?=$DataVuelo->REGULAR->Tarifa.'|'.$DataVuelo->BASICA->Clase."|".$key."|".$ArrivalDateTime."|".$DepartureDateTime?>">
            <span class="tarifa_<?=$TipoVuelo?>"><?= $DataVuelo->REGULAR->Tarifa ?></span>
            <span class="infomas">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$DataVuelo->ResBookDesigQuantity?> últimos asientos <br> <b>Condiciones</b></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        Tarifa valida sólo para viajes Ida y Vuelta <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima 6 meses <br>
                        <div class="dropdown-divider"></div>
                        Niños entre 2 y 11 años: 33% de descuento <br>
                        <div class="dropdown-divider"></div>
                        Infantes entre 0 y 2 años sin ocupar asiento: sin cargos. <br>
                        <div class="dropdown-divider"></div>
                        Cambios por vuelo/fecha/endosos dentro de las 24 horas a la salida del vuelo USD 15 + IGV. <br>
                        <div class="dropdown-divider"></div>
                        ver más en Paso 3. <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima: sin restricción.
                    </div>
                </div>
            </span>
        </label>
    </div>
</td>
    
<?php
}else{ ?>
    <td><div class='form-check'></div></td>
    <?php 
}

if($tarifa_premium){ ?>
    <td>
    <div class="form-check">
        <label class="form-check-label" for="exampleRadios1">
            <input class="form-check-input uno uno" type="radio" name="grupo_<?=$TipoVuelo?>" id="chk_tarifa" value="<?=$DataVuelo->PREMIUM->Tarifa.'|'.$DataVuelo->PREMIUM->Clase."|".$key."|".$ArrivalDateTime."|".$DepartureDateTime?>">
            <span class="tarifa_<?=$TipoVuelo?>"><?= $DataVuelo->PREMIUM->Tarifa ?></span>
            <span class="infomas">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?=$DataVuelo->ResBookDesigQuantity?> últimos asientos <br> <b>Condiciones</b></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        Tarifa valida sólo para viajes Ida y Vuelta <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima 6 meses <br>
                        <div class="dropdown-divider"></div>
                        Niños entre 2 y 11 años: 33% de descuento <br>
                        <div class="dropdown-divider"></div>
                        Infantes entre 0 y 2 años sin ocupar asiento: sin cargos. <br>
                        <div class="dropdown-divider"></div>
                        Cambios por vuelo/fecha/endosos dentro de las 24 horas a la salida del vuelo USD 15 + IGV. <br>
                        <div class="dropdown-divider"></div>
                        ver más en Paso 3. <br>
                        <div class="dropdown-divider"></div>
                        Estadía máxima: sin restricción.
                    </div>
                </div>
            </span>
        </label>
    </div>
</td>
    
<?php
}else{ ?>
    <td><div class='form-check'></div></td>
    <?php 
}
?>
