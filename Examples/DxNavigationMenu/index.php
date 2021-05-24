<?php

include  '../../vendor/autoload.php';

use JsBuilder\DevExtreme\DevExtreme;
use JsBuilder\DevExtreme\DxThemes;
use JsBuilder\DevExtreme\DxLanguage;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= DevExtreme::SetTheme(DxThemes::MaterialOrangeLight)
        ->SetLang(DxLanguage::Turkish)
        ->GetJavaScriptLibrary() ?>

    <title>JSBuilder</title>
</head>
<body class="bg-white">

<div class="card m-5 border shadow rounded">
    <h5 class="h5 m-3">PHP-DxNavigationMenu</h5>
    <div class="p-3" id="navMenu"></div>
</div>

<script>

</script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
