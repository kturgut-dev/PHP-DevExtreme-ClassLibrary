<?php

namespace JsBuilder\DxDataGrid;

class DxDataGrid
{
    // [START] Variables
    private static string $devextremeGrid = "";
    private static array $replaceData = array(
        "tableName" => "tableName",
    );
    private static array $columns = array();
    private static array $DevExtremeGridForm = array();
    // [END]

    // [START] Custom Operations
    private static function Initialize_DevExtreme()
    {
        self::$devextremeGrid = '$(function(){' . PHP_EOL;
        self::$devextremeGrid .= 'DevExpress.localization.locale(navigator.language);' . PHP_EOL;
        self::$devextremeGrid .= 'var {{tableName}} = $("#{{tableName}}").dxDataGrid({{DevExtremeGridFormat}});' . PHP_EOL;
        self::$devextremeGrid .= '});';
    }

    private static function Grid_Refresh()
    {
        foreach (self::$DevExtremeGridForm as $key => $value) {
            self::$DevExtremeGridForm[$key] = ($value);
        }

        $grid = self::$devextremeGrid;

        if (array_key_exists("onFocusedRowChanged", self::$DevExtremeGridForm)) {
//            $function = "#!!{{funcName}}()!!#";

//            $grid = json_encode($grid);
            str_replace('"#!!', '', $grid);
            str_replace('{{funcName}}', self::$DevExtremeGridForm["onFocusedRowChanged"], $grid);
            str_replace('!!#"', '', $grid);
//            echo $string;
//            die();
        }

        $grid = str_replace("{{DevExtremeGridFormat}}", json_encode(self::$DevExtremeGridForm), $grid);
        foreach (self::$replaceData as $key => $value) {
            $grid = str_replace("{{" . $key . "}}", $value, $grid);
        }



        self::$devextremeGrid = $grid;
    }

    /**
     * @param string $tableName
     * @return static
     * Set parameter and table id
     */
    public static function Create(string $tableName): self
    {
        self::$replaceData["tableName"] = $tableName;
        return new self();
    }

    public static function Build(): string
    {
        self::Initialize_DevExtreme();
        self::Grid_Refresh();
        return self::$devextremeGrid;
    }
    // [END]

    // [START] DataGridView Operations
    public static function KeyExpr(string $key = '')
    {
        //Only ArrayDataSource use
        if (is_string($key) && !empty($key))
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

    public static function JsonDataSource(array $dataSource): self
    {
        self::$DevExtremeGridForm["dataSource"] = $dataSource;
        return new self();
    }

    public static function AddColumn(string $fieldName, string $displayName, int $width = 0, bool $visible = true, string $dataType = 'string', int $groupIndex = -1, string $sortOrder = ''): self
    {
        $col = array(
            "dataField" => $fieldName,
            "caption" => $displayName,
        );

        if ($dataType != 'string') {
            $col["dataType"] = $dataType;
        }

        if (!$visible) {
            $col["visible"] = $visible;;
        }

        if ($width != 0) {
            $col["width"] = $width;
        }

        if ($groupIndex != -1) {
            $col["groupIndex"] = $groupIndex;
        }

        if (!empty($sortOrder))
            $col["sortOrder"] = $sortOrder; //asc - desc

        array_push(self::$columns, $col);
        self::$DevExtremeGridForm["columns"] = (self::$columns);
        return new self();
    }

    public static function AddDxColumn(DxColumn $dxColumn): self
    {
        array_push(self::$columns, $dxColumn->getColumn());
        self::$DevExtremeGridForm["columns"] = (self::$columns);
        return new self();
    }


    public static function AllowColumnReordering(bool $visible = true): self
    {
        self::$DevExtremeGridForm["allowColumnReordering"] = $visible;
        return new self();
    }

    public static function AddColumns(array $columns): self
    {
        self::$DevExtremeGridForm["columns"] = $columns;
        return new self();
    }

    public static function GroupPanel(bool $visible = true, string $emptyText = '')
    {
        self::$DevExtremeGridForm["groupPanel"]["visible"] = $visible;
        if (!empty($emptyText) && is_string($emptyText))
            self::$DevExtremeGridForm["groupPanel"]["emptyPanelText"] = $emptyText;
        return new self();
    }

    public static function FilterRow(bool $visible, string $applyFilter = "auto"): self
    {
        self::$DevExtremeGridForm["filterRow"]["visible"] = $visible;
        if (!empty($applyFilter) && is_string($applyFilter))
            self::$DevExtremeGridForm["filterRow"]["applyFilter"] = $applyFilter;
        return new self();
    }

    public static function HeaderFilter(bool $visible): self
    {
        self::$DevExtremeGridForm["headerFilter"]["visible"] = $visible;
        return new self();
    }

    public static function FilterPanel(bool $visible = true): self
    {
        self::$DevExtremeGridForm["filterPanel"]["visible"] = $visible;
        return new self();
    }

    public static function Paging(int $pageSize = 10): self
    {
        if (is_integer($pageSize))
            self::$DevExtremeGridForm["paging"]["pageSize"] = $pageSize;
        return new self();
    }

    public static function Pager(bool $showPageSizeSelector = true, array $allowedPageSizes = array(5, 10, 20), bool $showInfo = true): self
    {
        self::$DevExtremeGridForm["pager"]["showPageSizeSelector"] = $showPageSizeSelector;

        if (is_array($allowedPageSizes)) {
            foreach ($allowedPageSizes as $allowedPageSize) {
                if (!is_integer($allowedPageSize))
                    throw  new Exception("Variable must be integer array.");
            }
            self::$DevExtremeGridForm["pager"]["allowedPageSizes"] = $allowedPageSizes;
        }
        self::$DevExtremeGridForm["pager"]["showInfo"] = $showInfo;
        return new self();
    }

    public static function FocusedRowEnabled(bool $isActive = true): self
    {
        if (is_bool($isActive))
            self::$DevExtremeGridForm["focusedRowEnabled"] = $isActive;
        return new self();
    }

    public static function RemoteOperations(bool $isActive)
    {
        //To notify the DataGrid that data is processed on the server, set the remoteOperations property to true.
        if (is_bool($isActive))
            self::$DevExtremeGridForm["remoteOperations"] = $isActive;

        return new self();
    }

    public static function Editing(bool $allowAdding, bool $allowUpdating = false, bool $allowDeleting = false, string $startEditAction = 'dblClick')
    {

        if (is_bool($allowAdding))
            self::$DevExtremeGridForm["editing"]["allowAdding"] = $allowAdding;

        if (is_bool($allowUpdating))
            self::$DevExtremeGridForm["editing"]["allowUpdating"] = $allowUpdating;

        if (is_bool($allowDeleting))
            self::$DevExtremeGridForm["editing"]["allowDeleting"] = $allowDeleting;

        if (is_string($startEditAction))
            self::$DevExtremeGridForm["editing"]["startEditAction"] = $startEditAction;

        return new self();
    }

    public static function EditingMode(string $mode = 'cell') //popup-form-batch-cell
    {
        //https://js.devexpress.com/Demos/WidgetsGallery/Demo/DataGrid/FormEditing/jQuery/Light/
        if (is_string($mode))
            self::$DevExtremeGridForm["editing"]["mode"] = $mode;

        return new self();
    }

    public static function OnFocusedRowChanged(string $funcName)
    {
        if (is_string($funcName))
            self::$DevExtremeGridForm["onFocusedRowChanged"] = $funcName;

        return new self();
    }

    // [END]
}
