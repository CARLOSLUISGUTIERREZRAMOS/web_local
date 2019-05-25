<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Las Mejores tarifas aéreas para peruanos y extranjeros. Vuela por el Perú: Cusco, Tarapoto, Iquitos, Pucallpa, Lima; promociones especiales">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aerolíneas StarPerú</title>
        <link rel="stylesheet" href="<?= base_url() ?>css/bootstrap.css">
        <link rel="stylesheet" href="<?= base_url() ?>css/font-awesome.css">
        <link rel="stylesheet" href="<?= base_url() ?>css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    </head>
    <body class="internas nohero">
        <div class="interfaz">
            <header class="cabecera">
                <div class="container-fluid">
                    <div class="row no-gutters fondo">
                        <div class="col">
                            <div class="container">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <div class="row no-gutters">
                                            <div class="col-sm-12 col-md-4 logotipo">
                                                <h1><img src="<?= base_url() ?>img/Logotipo.png" alt=""></h1>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <nav class="navbar navbar-expand sec-nav">
                                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse" id="navbarsExample02">
                                                        <ul class="navbar-nav ml-auto">
                                                            <li class="nav-item telefono">
                                                                <strong>(511) 2138813</strong>
                                                            </li>
                                                            <li class="nav-item idiomas">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        ES
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="#">ES</a>
                                                                        <!--<a class="dropdown-item" href="#">ENG</a>-->
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nav-item facebook">
                                                                <a href="">facebook</a>
                                                            </li>
                                                            <li class="nav-item blog">
                                                                <a href="http://blog.starperu.com/es/" class="nav-link">
                                                                    <img src="img/icon-blog.png" class="off" alt="">
                                                                    <img src="img/icon-blog-on.png" class="on" alt="">
                                                                    <span>Blog</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                                <nav class="navbar navbar-expand-md navbar-dark bg-dark main-nav">
                                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse" id="navbarsExample03">
                                                        <ul class="navbar-nav ml-auto">
                                                            <li class="nav-item active">
                                                                <a class="nav-link" href="index.html">Inicio</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="destinos.html">Destinos</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="promociones.html">Promociones</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="servicios-especiales.html">Servicios Especiales</a>
                                                            </li>
                                                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Volar en StarPerú
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                                    <a class="dropdown-item" href="servicio-al-cliente.html">Servicios al cliente</a>
                                                                    <a class="dropdown-item" href="servicios-especiales.html">Servicios especiales</a>
                                                                    <a class="dropdown-item" href="viajes-grupales.html">Viajes grupales</a>
                                                                    <a class="dropdown-item" href="oficinas.html">Oficinas</a>
                                                                    <a class="dropdown-item" href="sobre-mi-equipaje.html">Sobre mi equipaje</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="contenidos">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="alert alert-danger" role="alert">
                                <strong>Surgió un error al realizar el pago</strong><br>
                                <?= $error_code ?>
                            </div>
                            <div class="accordion destinos--2" id="accordionStar">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <a class = "accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"  aria-controls="collapseOne">
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
                                            <h3>Datos de la Compra:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
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
                                                                <th>Monto de la Transacción</th>
                                                                <td><?= $data_reserva->total_pagar ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fecha y Hora del pedido:</th>
                                                                <td><?= $data_reserva->fecha_registro ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Código de error</th>
                                                                <td><?= urldecode($msg_pp) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingThree">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <h3>Sugerencia:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <br>
                                                    <div class="alert alert-info" role="alert">
                                                        Por favor tome nota de su código de reserva: <?=$data_reserva->pnr?> e intente su pago nuevamente ingresando <a href="<?=base_url()?>PagoReservas/ReprocesarPago?pnr=<?=$data_reserva->pnr?>&reserva_id=<?=$data_reserva->id?>" id="redirect_pago_reserva">aquí</a>
                                                    </div>
                                                    <div class="alert alert-info" role="alert">
                                                        Si su compra fué denegada lo puede pagar en efectivo o a través de su Banca por Internet en el BCP, BBVA e Interbank. Scotiabank presionando <a href="#!">aquí</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="card resumen destinos-2">
                                <table>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="nomest">Nombre del establecimiento:</label>
                                                <input type="text" class="form-control" aria-describedby="nomest" id="nomest" value="Star Perú" disabled>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="codres">Código de Reserva:</label>
                                                <input type="text" class="form-control" aria-describedby="codres" id="pnr" name="pnr" value="<?= $data_reserva->pnr ?>" disabled>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="montotrans">Monto de la transacción:</label>
                                                <input type="text" class="form-control" aria-describedby="montotrans" id="montotrans" value="<?= $data_reserva->total_pagar ?>" disabled>
                                            </div>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="pie">
                <div class="container-fluid">
                    <div class="row no-gutters">
                        <div class="col-sm-12 col-md-5 menu-inf">
                            <div class="row no-gutters justify-content-end">
                                <div class="col-sm-12 col-md-11">
                                    <img src="img/Logotipo.png" alt="">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><a href="libro-de-reclamaciones.html">Libro de reclamaciones</a></li>
                                        <li class="list-inline-item"><a href="la-empresa.html">La Empresa</a></li>
                                        <li class="list-inline-item"><a href="contacto.html">Contacto</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 redes">
                            <div class="row no-gutters align-items-end">
                                <div class="col-sm-12 col-md-9">
                                    <p>CALL CENTER (511) 705-9000 <br>
                                        Atención diaria – 08:00 a 20:00Hrs.</p>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <ul class="list-inline">
                                        <li class="list-inline-item facebook">
                                            <a href="https://www.facebook.com/aerolineas.starperu?fref=ts" class="nav-link">
                                                facebook
                                            </a>
                                        </li>
                                        <li class="list-inline-item twitter">
                                            <a href="https://twitter.com/starperu_" class="nav-link">
                                                twitter
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-12 text-center disclaimer">
                            <p><small>2018 Star up S.A - <a href="contrato-de-transporte.html">Contrato de transporte</a> - <a href="condiciones-de-venta.html">Condiciones de venta</a> - <a href="condiciones-clases-tarifarias.html">Condiciones de clases tarifarias</a> - <a href="endosos-y-postergaciones.html">Endosos y postergaciones</a> - <a href="preguntas-frecuentes.html">FAQ</a> - <a href="privacidad.html">Privacidad</a><!-- - <a href="prensa-e-imagen.html">Prensa e imagen</a>--> - <a href="flota.html">Flota</a> - <a href="mapa-del-sitio.html">Mapa del sitio</a></small></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="<?= base_url() ?>js/jquery.min.js" charset="utf-8"></script>
        <script src="<?= base_url() ?>js/popper.min.js" charset="utf-8"></script>
        <script src="<?= base_url() ?>js/bootstrap.min.js" charset="utf-8"></script>
    </body>
</html>