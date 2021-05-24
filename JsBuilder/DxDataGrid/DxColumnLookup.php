<?php

namespace JsBuilder\DxDataGrid;

class DxColumnLookup
{

    public ?object $DataSource = null;
    public string $DisplayExpr;
    public string $ValueExpr;

    public function __construct(object $DataSource, string $DisplayExpr, string $ValueExpr)
    {
        $this->DataSource = $DataSource;
        $this->DisplayExpr = $DisplayExpr;
        $this->ValueExpr = $ValueExpr;
    }
}