<?php
include 'autoload.php';

use Helpers\DataGenerator;
use JsBuilder\DevExtremeGridThemes;
use JsBuilder\DevExtremeGridBuilder;

$ds = DataGenerator::DataSourceGenerate(1);

$tableName = "gridView_test";
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= DevExtremeGridBuilder::SetTheme(DevExtremeGridThemes::MaterialOrangeLight)
        ->SetLang(\JsBuilder\DevExtremeLanguage::$Turkish)
        ->GetJavaScriptLibrary() ?>

    <title>JSBuilder</title>
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->
<div class="card m-5 border">
    <h5 class="h5 m-3">DevExtreme PHP</h5>
    <div class="p-3" id="<?= $tableName ?>"></div>
</div>

<script>
    <?php echo DevExtremeGridBuilder::Create($tableName)
        ->setKeyExpr("Id")
        ->SearchPanel(true)
        ->GroupPanel(true)
        ->addColumn("Id", "Id")
        ->addColumn("FullName", "Name and Surname")
        ->addColumn("Email", "E-mail")
        ->dataSource($ds)
        ->Build(); ?>
</script>
<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
