<?php
require_once './connect.php';
header('Connect-Type: application/json; charset = utf-8');

if($_SERVER['REQUEST_METHOD'] !='GET')
{
    http_response_code(405);
    die(json_encode(array('code' => 405 ,'message' => 'API này chỉ hỗ trợ GET')));
}
if(get_bill($conn)['code'] != 0)
{
    die(json_encode(array('code' => 1, 'message' => get_bill($conn)['message'])));
}
echo json_encode(array('code' => 0, 'data' => get_bill($conn)['data'])) ;
?>