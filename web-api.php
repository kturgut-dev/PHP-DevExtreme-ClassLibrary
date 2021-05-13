<?php
include './vendor/autoload.php';

use Helpers\DataGenerator;

echo json_encode(array("data" => DataGenerator::DataSourceGenerate(20), "totalCount" => 20));
