<header class="cabecera">
        <div class="container-fluid">
            <div class="row no-gutters fondo">
                <div class="col">
                    <div class="container">
                        <div class="row no-gutters">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-sm-12 col-md-4 logotipo">
                                        <h1><?=img('img/Logotipo.png');?></h1>
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
                                           <?php $this->load->view('bloques_main/v_navbar_menu_superior'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>