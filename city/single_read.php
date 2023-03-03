<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/city.php';
$database = new Database();
$db = $database->getConnection();
$items = new City($db);
$stmt = $items->getCity();
$itemCount = $stmt->rowCount();

echo json_encode($itemCount);
if($itemCount > 0){

    $cityArr = array();
    $cityArr["cities"] = array();
    $cityArr["itemCount"] = $itemCount;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $cit = array(
            "id" => $id,
            "name" => $name
        );
        array_push($cityArr["cities"], $cit);
    }
    echo json_encode($cityArr);
}
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
