<?php
include __DIR__ . '/vendor/autoload.php';

use Helpers\DataGenerator;
use DevExtreme\DxThemes;
use DevExtreme\DxColumn;
use DevExtreme\DxLanguage;
use JsBuilder\DevExtremeGridBuilder;

$ds = DataGenerator::DataSourceGenerate(20);

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

    <?= DevExtremeGridBuilder::SetTheme(DxThemes::MaterialOrangeLight)
        ->SetLang(DxLanguage::Turkish)
        ->GetJavaScriptLibrary() ?>

    <title>JSBuilder</title>
</head>
<body class="bg-white">

<div class="card m-5 border shadow rounded">
    <h5 class="h5 m-3">PHP-DevExtremeGridBuilder</h5>
    <span class="m-3">Focused Row Key: <span id="focusedRow">NULL</span></span>
    <div class="p-3" id="<?= $tableName ?>"></div>
</div>

<script>
    <?php echo DevExtremeGridBuilder::Create($tableName, 'Id')
        ->SearchPanel()
        ->GroupPanel(true)
        ->FilterRow(true)
        ->FilterPanel()
        ->Paging(10)
        ->Pager(true)
        ->FocusedRowEnabled()
        ->HeaderFilter(true)
        ->AddDxColumn(new DxColumn("Id", "Kayıt No"))
        ->AddColumn("FullName", "Name and Surname")
        ->AddColumn("Email", "E-mail")
        ->JsonDataSource($ds)
        ->Build(); ?>


    $("#gridView_test").dxDataGrid({
        onFocusedRowChanged: function (e) {
            const focusedRowKey = e.component.option("focusedRowKey");
            $("#focusedRow").text(focusedRowKey);
        }
    });
</script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
