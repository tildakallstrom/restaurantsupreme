<?php
require 'includes/config.php';
require 'includes/Database.php';
require 'classes/Menu.class.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$menu = new Menu();
switch ($method) {
    case 'GET':
        http_response_code(200);

        $response = $menu->getMenu();
        if (count($response) == 0) {
            $response = array("message" => "No menu found.");
        }
        if (isset($id)) {
            $result = $menu->getMenuById($id);
        } else {
            $result = $menu->getMenu();
        }
        if (sizeof($result) > 0) {
            http_response_code(200); 
        } else {
            http_response_code(404); 
            $result = array("message" => "No menu found.");
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if ($data->title == "" || $data->content == "" || $data->author == "" || $data->date == "") {
            $response = array("message" => "Fill in the form");
            http_response_code(400); 
        } else {
            if ($menu->create($data->title, $data->content, $data->author, $data->date)) {
                $response = array("message" => "The menu was created.");
                http_response_code(201); 
            } else {
                $response = array("message" => "Something went wrong, try again.");
                http_response_code(500); 
            }
        }
        break;
    case 'PUT':
        if (!isset($id)) {
            http_response_code(510); 
            $result = array("message" => "No id is sent");
        } else {
            $data = json_decode(file_get_contents("php://input"));

            if ($menu->updateMenu($id, $data)) {
                http_response_code(200);
                $result = array("message" => "The menu was updated");
            } else {
                http_response_code(503);
                $result = array("message" => "No id has been sent");
            }
        }
        break;
    case 'DELETE':
        if (!isset($id)) {
            http_response_code(510); 
            $result = array("message" => "No id has been sent.");
        } else {
            if ($menu->deleteMenu($id)) {
                http_response_code(200);
                $result = array("message" => "The menu has been deleted.");
            } else {
                http_response_code(503); 
                $result = array("message" => "The menu has not been deleted.");
            }
        }
        break;
}
echo json_encode($result);