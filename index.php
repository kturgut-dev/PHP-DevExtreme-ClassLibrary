<?php
function class_autoloader($class) {
    include  $class . '.class.php';
}

spl_autoload_register('class_autoloader');

use JsBuilder\DevExtremeGridThemes;
use JsBuilder\DevExtremeGridBuilder;

$ds = array(
    array(
        "Id" => "1",
        "Email" => "denem@mail.co"
    ),
    array(
        "Id" => "2",
        "Email" => "denem2@mail.co"
    )
);
$tableName = "gridView_test";
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

    <?= DevExtremeGridBuilder:: setTheme(DevExtremeGridThemes::MaterialOrangeLight)->GetJavaScriptLibrary() ?>

    <title>JSBuilder</title>
</head>
<body>
<!-- Optional JavaScript; choose one of the two! -->
<div class="card m-5 border">
    <h5 class="h5 m-3">DevExtreme PHP</h5>
    <div class="p-3" id="<?= $tableName ?>"></div>
</div>

<script>
    <?php echo DevExtremeGridBuilder::createTable($tableName)
        ->setKeyExpr("Id")
        ->addColumn("Id", "Kayıt No")
        ->addColumn("Email", "E-Posta")
        ->dataSource($ds)
        ->make(); ?>
</script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
        crossorigin="anonymous"></script>
</body>
</html>
