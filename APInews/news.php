<?php
require 'includes/config.php';
require 'includes/Database.php';
require 'classes/News.class.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$news = new News();
switch ($method) {
    case 'GET':
        http_response_code(200);

        $response = $news->getNews();
        if (count($response) == 0) {
            $response = array("message" => "No news found.");
        }
        if (isset($id)) {
            $result = $news->getNewsById($id);
        } else {
            $result = $news->getNews();
        }
        if (sizeof($result) > 0) {
            http_response_code(200); 
        } else {
            http_response_code(404); 
            $result = array("message" => "No news found.");
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if ($data->title == "" || $data->content == "" || $data->author == "" || $data->date == "") {
            $response = array("message" => "Fill in the form");
            http_response_code(400); 
        } else {
            if ($news->create($data->title, $data->content, $data->author, $data->date)) {
                $response = array("message" => "The article was created.");
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

            if ($news->updateNews($id, $data)) {
                http_response_code(200);
                $result = array("message" => "The article was updated");
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
            if ($news->deleteNews($id)) {
                http_response_code(200);
                $result = array("message" => "The article has been deleted.");
            } else {
                http_response_code(503); 
                $result = array("message" => "The article has not been deleted.");
            }
        }
        break;
}
echo json_encode($result);