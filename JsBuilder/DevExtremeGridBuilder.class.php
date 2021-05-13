<?php

namespace JsBuilder;

class DevExtremeGridBuilder
{
    private static $devextremeGrid = "";
    private static $typePath = "JsBuilder/DevExtremeGrid.txt";
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

        return self::GenerateJavaScriptLibrary($DevExtremeGridLibs);
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
