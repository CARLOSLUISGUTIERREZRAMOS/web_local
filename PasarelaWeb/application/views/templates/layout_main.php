
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Las Mejores tarifas aéreas para peruanos y extranjeros. Vuela por el Perú: Cusco, Tarapoto, Iquitos, Pucallpa, Lima; promociones especiales">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aerolíneas StarPerú</title>
        <link href="<?= base_url() ?>img/star.ico" rel="shortcut icon" />
        <?= link_tag('css/bootstrap.css'); ?>
        <?= link_tag('css/font-awesome.css'); ?>
        <?= link_tag('css/main.css'); ?>
        <?= link_tag('css/dhtmlxcalendar.css'); ?>
        <?php echo $styles ?>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    </head>
    <body class="<?= $class_body ?>">
        <div class="interfaz">
            <header class="cabecera">
                <div class="container-fluid">
                    <?php
                    if ($CARGA_PAGINA === 'INICIO') {
                        $muestra_menu = FALSE;
                    } else {
                        $muestra_menu = TRUE;
                    }
                    $this->template->load_header_main($muestra_menu);
                    ?>
                    <?php
//                        if ($CARGA_PAGINA != 'INICIO') {
                    $data['bloque_carousel'] = $CARGA_PAGINA;
                    $data['MUESTRA_CAROUSEL'] = $MUESTRA_CAROUSEL;
                    $this->load->view('bloques_main/v_carousel', $data);
//                        }
                    ?>
                </div>
                <?php if ($MUESTRA_CALENDARIO === TRUE) { ?>
                    <div class="container reserva">
                        <?php $this->template->load_calendar(); ?>
                    </div>
                    <?php
                }
                ?>
            </header>
            <main class="contenidos">
                <?php
                if ($CARGA_PAGINA === 'INICIO') {
                    $this->load->view('bloques_main/v_contenidos');
                } else {
                    $this->load->view($url);
                }
                ?>
            </main>

            <?php $this->template->load_footer(); ?>
        </div>
        <?= script_tag('js/jquery.min.js'); ?>
        <?= script_tag('js/popper.min.js'); ?>
        <?= script_tag('js/bootstrap.min.js'); ?>
        <?= script_tag('js/dhtmlxcalendar.js'); ?>
        <?= script_tag('js/web/main.js'); ?>
        <?php echo $scripts; ?>
    </body>
</html>

<?php
$this->load->view('templates/v_error');
?>

<script>

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    }
    
    var bool= getParameterByName(error);
    
    alert(bool);
    
</script>