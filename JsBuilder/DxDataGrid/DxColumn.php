<?php

namespace JsBuilder\DxDataGrid;

class DxColumn
{
    //json_encode((array) $DxColumn);
    private string $DataField;
    private string $Caption;
    public ?bool $Visible = null;
    public ?int $Width = null;
    public ?string $DataType = null;
    public ?int $GroupIndex = null;
    public ?string $SortOrder = null;
    public ?bool $Enabled = null;
    public ?bool $AllowEditing = null;
    public ?DxColumnLookup $Lookup = null;

    public function __construct(string $DataField, string $Caption)
    {
        $this->DataField = $DataField;
        $this->Caption = $Caption;
    }

    public function jsonSerialize(): string
    {
        return json_encode($this->getColumn());
    }

    public function getColumn()
    {
        $res = array(
            "dataField" => $this->DataField,
            "caption" => $this->Caption,
        );

        if (!is_null($this->Visible))
            $res["visible"] = $this->Visible;

        if (!is_null($this->Width))
            $res["width"] = $this->Width;

        if (!is_null($this->DataType))
            $res["dataType"] = $this->DataType;

        if (!is_null($this->GroupIndex))
            $res["groupIndex"] = $this->GroupIndex;

        if (!is_null($this->SortOrder))
            $res["sortOrder"] = $this->SortOrder;

        if (!is_null($this->Enabled))
            $res["enabled"] = $this->Enabled;

        if (!is_null($this->AllowEditing))
            $res["allowEditing"] = $this->AllowEditing;

        if (!is_null($this->Lookup))
            $res["lookup"] = $this->Lookup;

        return $res;
    }
}