<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
       <title>Aerolíneas StarPerú</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/app/error.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    </head>

    <body class="text-center">
        <form class="form-signin">
            <img class="mb-4" src="<?= base_url()?>img/logotipo2.png" alt="">
            <h1 class="h3 mb-3 font-weight-normal"><?=$msg_error?></h1>
            
            <button class="btn btn-lg btn-primary btn-block" onClick="history.back()">Volver</button>
            <p class="mt-5 mb-3 text-muted">Error <?=$codigo_error?></p>
        </form>
    </body>
</html>
