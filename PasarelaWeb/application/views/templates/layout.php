<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Las Mejores tarifas aéreas para peruanos y extranjeros. Vuela por el Perú: Cusco, Tarapoto, Iquitos, Pucallpa, Lima; promociones especiales">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aerolíneas StarPerú</title>
        <link href="img/star.ico" rel="shortcut icon" />
        <?= link_tag('css/bootstrap.css'); ?>
        <?= link_tag('css/font-awesome.css'); ?>
        <?= link_tag('css/main.css'); ?>
        <?php echo $styles ?>
        <?php echo $scripts_analitics ?>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
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
            ga('send', 'pageview');</script> 
    </head>
    <body class="internas nohero">
        <div class="interfaz">
            <?php $this->template->load_header(); ?>
            <main class="contenidos">
                <?= $contents ?>
            </main>    
            <?php $this->template->load_footer(); ?>
        </div>

    </body>
    <script>
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
    <!-- End Facebook Pixel Code -->
    <!-- Analytics -->

    <?= script_tag('js/jquery.min.js'); ?>
    <?= script_tag('js/popper.min.js'); ?>
    <?= script_tag('js/bootstrap.min.js'); ?>
    <?php echo $scripts; ?>
</html>
<?php $this->load->view('templates/v_error') ?>