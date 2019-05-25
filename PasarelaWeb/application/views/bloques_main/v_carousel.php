<?php if ($MUESTRA_CAROUSEL) { ?>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">

            <?php if ($bloque_carousel == 'INICIO') { ?>
                <div class="carousel-item active">
                    <img class="d-block w-100" src="<?= base_url() ?>images/img-indexp-01.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?= base_url() ?>images/img-indexp-02.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="<?= base_url() ?>images/img-indexp-03.jpg" alt="Third slide">
                </div>    
                <?php
            } else {

                switch ($bloque_carousel) {

                    case 'IQT':
                        $ruta_imagen = "images/img-destinoint-iquitos01.jpg";
                        break;
                    case 'CUZ':
                        $ruta_imagen = "images/img-destinoint-cusco01.jpg";
                        break;
                    case 'TPP':
                        $ruta_imagen = "images/img-destinoint-tarapoto01.jpg";
                        break;
                    case 'CIX':
                        $ruta_imagen = "images/img-destino-chiclayo01.jpg";
                        break;
                    case 'PCL':
                        $ruta_imagen = "images/img-destinoint-iquitos01.jpg";
                        break;
                    case 'CJA':
                        $ruta_imagen = "images/img-destino-cajamarca01.jpg";
                        break;
                    case 'DESTINOS':
                        $ruta_imagen = "images/img-destinos.jpg";
                        break;
                    case 'PROMOCIONES':
                        $ruta_imagen = "images/img-promociones.jpg";
                        break;
                    case 'SERVICIOS_ESPECIALES':
                        $ruta_imagen = "images/img-serviciosespeciales.jpg";
                        break;
                    case 'SERVICIOS_AL_CLIENTE':
                        $ruta_imagen = "images/img-serviciocliente.jpg";
                        break;
                    case 'VIAJES_GRUPALES':
                        $ruta_imagen = "images/img-viajesgrupales.jpg";
                        break;
                    case 'OFICINAS':
                        $ruta_imagen = "images/img-oficinas.jpg";
                        break;
                    case 'SOBRE_MI_EQUIPAJE':
                        $ruta_imagen = "images/img-sobreequipaje.jpg";
                        break;
                    case 'CARGO':
                        $ruta_imagen = "images/img-starperucargo.jpg";
                        break;
                    case 'FLOTA':
                        $ruta_imagen = "images/img-flota.jpg";
                        break;
                    case 'LA_EMPRESA':
                        $texto = "<h5>La <span>Empresa</span></h5>";
                        $carousel_caption = TRUE;
                        $ruta_imagen = "images/img-laempresa.jpg";
                        break;
                    case 'CONTACTO':
                        $ruta_imagen = "images/img-contacto.jpg";
                        break;
                    case 'CONTRATO_TRANSPORTE':
                        $carousel_caption = TRUE;
                        $texto = "<h5>Contrato de <span>transporte</span></h5>";
                        $ruta_imagen = "images/img-contratotransporte.jpg";
                        break;
                    case 'CONDICIONES_DE_VENTA':
                        $texto = "<h5>Condiciones de <span>venta</span></h5>";
                        $carousel_caption = TRUE;
                        $ruta_imagen = "images/img-contratotransporte.jpg";
                        break;
                    case 'CLASES_TARIFARIAS':
                        $texto = "<h5>Condiciones de <span>clases tarifarias</span></h5>";
                        $carousel_caption = TRUE;
                        $ruta_imagen = "images/img-condiciones-clasestarifarias.jpg";
                        break;
                    case 'ENDOSOS_POSTERGACIONES':
                        $carousel_caption = TRUE;
                        $texto = "<h5>Endosos y <span>postergaciones</span></h5>";
                        $ruta_imagen = "images/img-contratotransporte.jpg";
                        break;
                    case 'PREGUNTAS_FRECUENTES':
                        $carousel_caption = TRUE;
                        $texto = " <h5>Preguntas<span>Frecuentes</span></h5>";
                        $ruta_imagen = "images/img-faq.jpg";
                        break;
                    case 'PRIVACIDAD':
                        $carousel_caption = TRUE;
                        $texto = "<h5><span>Privacidad</span></h5>";
                        $ruta_imagen = "images/img-privacidad.jpg";
                        break;
                }
                ?>
                <div class="carousel-item active">
                    <?php if (isset($carousel_caption) && $carousel_caption === TRUE) { ?>
                        <div class="carousel-caption type-one">
                            <?= $texto ?>
                        </div>
                        <?php
                    }
                    ?>
                    <img class="d-block w-100" src="<?= base_url() . $ruta_imagen ?>" alt="First slide">
                </div>
                <?php
            }
            ?>

        </div>
    </div>
    <?php
}
?>
