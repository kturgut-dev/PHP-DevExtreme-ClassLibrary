<?php

include  '../../vendor/autoload.php';

use JsBuilder\DevExtreme\DevExtreme;
use JsBuilder\DevExtreme\DxThemes;
use JsBuilder\DxDataGrid\DxColumn;
use JsBuilder\DevExtreme\DxLanguage;
use JsBuilder\DxDataGrid\DxDataGrid;


$tableName = "gridView_test";

$idColumn =  new DxColumn("Id", "Kayıt No");
$idColumn->AllowEditing = false;



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
    <h5 class="h5 m-3">PHP-DevExtremeGridBuilder</h5>
    <span class="m-3">Focused Row Key: <span id="focusedRow">NULL</span></span>
    <div class="p-3" id="<?= $tableName ?>"></div>
</div>

<script>
    <?php echo DxDataGrid::Create($tableName)
        ->SearchPanel()
        ->FilterPanel()
        ->GroupPanel()
        ->FilterRow(true)
        ->Paging(10)
        ->Pager(true)
        ->FocusedRowEnabled()
        ->HeaderFilter(true)
        ->Editing(true,true)
        ->RemoteOperations(true)
        ->EditingMode("cell")
        ->AddDxColumn($idColumn)
        ->AddColumn("FullName", "Name and Surname")
        ->AddColumn("Email", "E-mail")
        ->OnFocusedRowChanged("deneme")
        ->Build(); ?>


    let apiUrl = 'http://localhost:8000/php-test/web-api.php';
    const store = new DevExpress.data.CustomStore({
        key: "Id",
        load: function (loadOptions) {
            const deferred = $.Deferred();
            $.get(apiUrl, loadOptions).done(function (response) {
                response = JSON.parse(response)
                deferred.resolve({data: response.data, totalCount: response.totalCount});
            });
            return deferred.promise();
        },
        insert: function (loadOptions) {
            console.log(loadOptions)
        }
    });


    $("#<?=$tableName?>").dxDataGrid({
        dataSource: store,
        // onFocusedRowChanged: function (e) {
        //     const focusedRowKey = e.component.option("focusedRowKey");
        //     $("#focusedRow").text(focusedRowKey);
        // }
    });

    function deneme(e){
        console.log(e)
    }

</script>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
