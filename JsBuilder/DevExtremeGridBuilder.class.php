<?php

namespace JsBuilder;

class DevExtremeGridBuilder
{
    private static $devextremeGrid = "";
    private static $typePath = "JsBuilder/DevExtremeGrid.txt";
    private static $theme = DevExtremeGridThemes::Light;
    private static $replaceData = array(
        "tableName" => "tableName",
    );
    private static $columns = array();
    public static $lang = "en";
    public static $DevExtremeGridLibs = array(
        "https://cdn3.devexpress.com/jslib/20.2.7/css/dx.common.css",
        "https://cdn3.devexpress.com/jslib/20.2.7/js/dx.all.js",
    );
    public static $DevExtremeGridForm = array();

    public static function SetLang(string $lang)
    {
        self::$lang = $lang;
        return new self();
    }

    private static function Initialize_DevExtreme()
    {
        self::$devextremeGrid = '$(function(){' . PHP_EOL;
        self::$devextremeGrid .= 'DevExpress.localization.locale(navigator.language);' . PHP_EOL;
        self::$devextremeGrid .= 'var {{tableName}} = $("#{{tableName}}").dxDataGrid({{DevExtremeGridFormat}});' . PHP_EOL;
        self::$devextremeGrid .= '})//.dxDataGrid("instance");';
    }

    public static function GetJavaScriptLibrary(): string
    {
        array_push(self::$DevExtremeGridLibs, "https://cdn3.devexpress.com/jslib/20.2.7/css/" . self::$theme);
        array_push(self::$DevExtremeGridLibs, "https://cdn3.devexpress.com/jslib/20.2.7/js/localization/dx.messages." . self::$lang . ".js");
        return self::GenerateJavaScriptLibrary(self::$DevExtremeGridLibs);
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
    static function Grid_Refresh()
    {
        foreach (self::$DevExtremeGridForm as $key => $value) {
            self::$DevExtremeGridForm[$key] = ($value);
        }

        $grid = self::$devextremeGrid;

        $grid = str_replace("{{DevExtremeGridFormat}}", json_encode(self::$DevExtremeGridForm), $grid);
        foreach (self::$replaceData as $key => $value) {
            $grid = str_replace("{{" . $key . "}}", $value, $grid);
        }
        self::$devextremeGrid = $grid;
    }

    public static function Create(string $tableName): self
    {
        self::$replaceData["tableName"] = $tableName;
        return new self();
    }

    public static function SetTheme(string $theme = '')
    {
        if (!is_null($theme) && !empty(trim($theme)))
            self::$theme = $theme;
        return new self();
    }

    public static function setColumns(array $columns): self
    {
        self::$DevExtremeGridForm["columns"] = $columns;
        return new self();
    }

    public static function addColumn(string $fieldName, string $displayName, int $width = 0, bool $visible = true, string $dataType = 'string'): self
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
        self::$DevExtremeGridForm["columns"] = (self::$columns);
        return new self();
    }

    public static function dataSource(array $dataSource): self
    {
        self::$DevExtremeGridForm["dataSource"] = $dataSource;
        return new self();
    }

    public static function setKeyExpr(string $key)
    {
        self::$DevExtremeGridForm["keyExpr"] = $key;
        return new self();
    }

    public static function SearchPanel(bool $visible = true, int $width = 240, string $placeHolder = "")
    {
        if (is_bool($visible))
            self::$DevExtremeGridForm["searchPanel"]["visible"] = $visible;
        if (is_integer($width))
            self::$DevExtremeGridForm["searchPanel"]["width"] = $width;
        if (!empty($placeHolder))
            array_push(self::$DevExtremeGridForm["searchPanel"], ["placeholder" => $placeHolder]);

        return new self();
    }

    public static function AllowColumnReordering(bool $visible)
    {
        self::$DevExtremeGridForm["groupingAutoExpandAll"] = $visible;
        return new self();
    }

    public static function GroupPanel(bool $visible, string $emptyText = '')
    {
        self::$DevExtremeGridForm["groupPanel"]["visible"] = $visible;
        if (!empty($emptyText) && is_string($emptyText))
            self::$DevExtremeGridForm["groupPanel"]["emptyPanelText"] = $emptyText;
        return new self();
    }

    public static function Build()
    {
        self::Initialize_DevExtreme();
        self::Grid_Refresh();
        return self::$devextremeGrid;
    }
}
