<?php

namespace JsBuilder;
class DevExtremeGridBuilder
{
    private static $devextremeGrid = "";
    private static $typePath = TableTypes::DevextremeGrid;
    private static $theme = DevExtremeGridThemes::Light;
    private static $replaceData = array(
        "tableName" => "tableName",
        "dataSource" => "[]",
        "columns" => "[]",
        "keyExpr" => "Id",
        "searchPanelVisible" => true,
        "searchPanelWidth" => 240,
        "searchPanelPlaceHolder" => "Search...",
        "headerFilterVisible" => true,
        "showBorders" => true,
        "columnsAutoWidth" => true,
        "focusedRowEnabled" => true,
        "filterRowVisible" => true,
        "filterRowApplyFilter" => "auto",
        "groupingAutoExpandAll" => true,
        "groupPanelVisible" => true,
        "groupPanelEmptyPanelText" => "Drag a column header here to group by that column",
    );
    private static $columns = array();

    private static function readTxtFile()
    {
        $filename = self::$typePath;
        $fp = fopen($filename, "r");

        self::$devextremeGrid = fread($fp, filesize($filename));
        fclose($fp);
    }

    public static function GetJavaScriptLibrary(): string
    {
        $DevExtremeGridLibs = array(
            "https://cdn3.devexpress.com/jslib/20.2.7/css/dx.common.css",
            "https://cdn3.devexpress.com/jslib/20.2.7/css/" . self::$theme,
            "https://cdn3.devexpress.com/jslib/20.2.7/js/dx.all.js",
        );

        $DataTableGridLibs = array(
            "https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css",
            "https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css",
            "https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js",
            "https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"
        );

        if (self::$typePath == TableTypes::DevextremeGrid) {
            return self::GenerateJavaScriptLibrary($DevExtremeGridLibs);
        } elseif (self::$typePath == TableTypes::DataTableGrid) {
            return self::GenerateJavaScriptLibrary($DataTableGridLibs);
        }
    }

    private static function GenerateJavaScriptLibrary(array $libraries): string
    {
        array_unshift($libraries, "https://code.jquery.com/jquery-3.5.1.min.js");
        $headString = "";
        foreach ($libraries as $value) {
            $template = "";
            if (strpos($value, ".js")) {
                $template = ' <script type="text/javascript" src="{{link}}"></script>' . PHP_EOL;
            } else {
                $template = ' <link rel="stylesheet" href="{{link}}">';
            }

            $headString = $headString . str_replace("{{link}}", $value, $template);
        }

        return $headString;
    }

    private
    static function refreshGrid()
    {
        self::$replaceData["columns"] = json_encode(self::$columns);

        $rows = self::$replaceData;
        $grid = self::$devextremeGrid;

        foreach ($rows as $key => $value) {
            // echo $key. " - ". $value . "<br>";
            $grid = str_replace("{{" . $key . "}}", $value, $grid);
        }

        self::$devextremeGrid = $grid;
    }

    public
    static function createTable(string $tableName)
    {
        self::$replaceData["tableName"] = $tableName;
        return new self();
    }

    public static function setTheme(string $theme = '')
    {
        if (!empty($theme))
            self::$theme = $theme;
        return new self();
    }

    public
    static function setColumns(array $columns)
    {
        //test edilecek
        $out = json_encode(($columns));
        self::$replaceData["columns"] = $out;
        return new self();
    }

    public
    static function addColumn(string $fieldName, string $displayName, int $width = 0, bool $visible = true, string $dataType = 'string')
    {
        $col = array(
            "dataField" => $fieldName,
            "caption" => $displayName,
            "visible" => $visible,
        );

        if ($dataType != 'string') {
            $col["dataType"] = $dataType;
        }

        if ($width != 0) {
            $col["width"] = $width;
        }

        array_push(self::$columns, $col);
        // echo json_encode(($col));
        return new self();
    }

    public
    static function dataSource(array $dataSource)
    {
        $out = json_encode($dataSource);
        self::$replaceData["dataSource"] = $out;
        return new self();
    }

    public static function setKeyExpr(string $key)
    {
        self::$replaceData["keyExpr"] = $key;
        return new self();
    }

    public static function SearchPanel(bool $visible = true, int $width = 240, string $placeHolder = "Search...")
    {
        self::$replaceData["searchPanelVisible"] = $visible;
        self::$replaceData["searchPanelWidth"] = $width;
        self::$replaceData["searchPanelPlaceHolder"] = $placeHolder;
        return new self();
    }

    public static function AllowColumnReordering(bool $visible)
    {
        self::$replaceData["groupingAutoExpandAll"] = $visible;
        return new self();
    }

    public static function GroupPanel(string $emptyText, bool $visible)
    {
        self::$replaceData["groupPanelVisible"] = $visible;
        self::$replaceData["groupPanelEmptyPanelText"] = $emptyText;
        return new self();
    }

    public
    static function make()
    {
        self::readTxtFile();
        self::refreshGrid();
        return self::$devextremeGrid;
    }
}

abstract class TableTypes
{
    const DevextremeGrid = "DevExtremeGrid.txt";
    const DataTableGrid = "DataTableGrid.txt";
}

abstract class DevExtremeGridThemes
{
    //Generic
    const Light = "dx.light.css";
    const Dark = "dx.dark.css";
    const Carmine = "dx.Carmine.css";
    const SoftBlue = "dx.softblue.css";
    const DarkViolet = "dx.darkviolet.css";
    const GreenMist = "dx.greenmist.css";
    //Generic Compact
    const LightCompact = "dx.light.compact.css";
    const DarkCompact = "dx.dark.compact.css";
    const CarmineCompact = "dx.Carmine.compact.css";
    const SoftBlueCompact = "dx.softblue.compact.css";
    const DarkVioletCompact = "dx.darkviolet.compact.css";
    const GreenMistCompact = "dx.greenmist.compact.css";
    //Material Design
    const MaterialBlueLight = "dx.material.blue.light.css";
    const MaterialBlueDark = "dx.material.blue.dark.css";
    const MaterialLimeLight = "dx.material.lime.light.css";
    const MaterialLimeDark = "dx.material.lime.dark.css";
    const MaterialOrangeLight = "dx.material.orange.light.css";
    const MaterialOrangeDark = "dx.material.orange.dark.css";
    const MaterialPurpleLight = "dx.material.purple.light.css";
    const MaterialPurpleDark = "dx.material.purple.dark.css";
    const MaterialTealLight = "dx.material.teal.light.css";
    const MaterialTealDark = "dx.material.teal.dark.css";
    //Material Design CompactCompact
    const MaterialBlueLightCompact = "dx.material.blue.light.compact.css";
    const MaterialBlueDarkCompact = "dx.material.blue.dark.compact.css";
    const MaterialLimeLightCompact = "dx.material.lime.light.compact.css";
    const MaterialLimeDarkCompact = "dx.material.lime.dark.compact.css";
    const MaterialOrangeLightCompact = "dx.material.orange.light.compact.css";
    const MaterialOrangeDarkCompact = "dx.material.orange.dark.compact.css";
    const MaterialPurpleLightCompact = "dx.material.purple.light.compact.css";
    const MaterialPurpleDarkCompact = "dx.material.purple.dark.compact.css";
    const MaterialTealLightCompact = "dx.material.teal.light.compact.css";
    const MaterialTealDarkCompact = "dx.material.teal.dark.compact.css";
}
