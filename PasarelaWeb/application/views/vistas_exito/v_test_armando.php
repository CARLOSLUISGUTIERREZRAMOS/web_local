
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
        <script type="text/javascript">

            function printDiv(ticketN)
            {

                var divToPrint = document.getElementById(ticketN);

                var newWin = window.open('', 'Print-Window');
//                var newWin = window.open("", "_self");

                newWin.document.open();

                newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                newWin.document.close();

                setTimeout(function () {
                    newWin.close();
                }, 1);

            }

//            function printDiv(nombreDiv) {
//
//                var contenido = document.getElementById(nombreDiv).innerHTML;
//                var contenidoOriginal = document.body.innerHTML;
//
//                document.body.innerHTML = contenido;
//
////                window.print();
//                if (window.print()) { 
//                    document.body.innerHTML = contenidoOriginal;
//                    return false; 
//                } 
//                else { 
////                    location.reload(); 
//                }
//            }
        </script>
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
                            <div class="alert alert-success" role="alert">
                                <strong>Transacción exitosa!</strong><br>
                            </div>
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <button type="button" class="btn btn-outline-danger">Danger</button>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="list-group" id="list-tab" role="tablist">
                                                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Termino A</a>
                                                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Termino B</a>
                                                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Termino C</a>
                                                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Termino D</a>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">Descripcion del termino A</div>
                                                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">Descripcion del termino B</div>
                                                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">Descripcion del termino C</div>
                                                        <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">Descripcion del termino D</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
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
                                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalLong">ver condiciones</button>
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <th>Fecha UNIX:</th>
                                                                <td><?php
                                                                    echo strtotime("2019-03-22 00:00:01") . "<br>";
                                                                    date_default_timezone_set('America/Lima');
                                                                    echo date("Y-m-d H:i:s", 190322205409);
                                                                    echo gmdate("Y-m-d\TH:i:s\Z", 190322205409)
                                                                    ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Fecha Hoy: </th>
                                                                <td><?= (new DateTime())->format('d/m/Y') ?></td>
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
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                            <h3>Datos de la Compra:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar" style="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <tbody>
                                                            <tr>
                                                                <th>Código de reserva:</th>
                                                                <td>OFLJFX</td>
                                                            </tr>

                                                            <tr>
                                                                <th>Número de pedido:</th>
                                                                <td>1745014</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Moneda:</th>
                                                                <td>USD</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Monto de la Transacción</th>
                                                                <td>0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Descripción del Producto</th>
                                                                <td>LIM - CUZ - LIM</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Código de error</th>
                                                                <td>423 - Operación denegada - se canceló el proceso de pago</td>
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
                                            <h3>Datos de Pasajeros:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#etktModal">Ver e-ticket</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    sad
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


<!-- Modal -->
<div class="modal full fade" id="etktModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> <?= img('img/Logotipo.png') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="areaImprimir">
                <?php echo $eticket ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="printDiv('areaImprimir')">Imprimir</button>
            </div>
        </div>
    </div>
</div>