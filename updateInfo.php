<?php
    require_once('./connect.php');
    if($_SERVER['REQUEST_METHOD']!='PUT'){
        http_response_code(405);
        die(json_encode(array('code'=>'405','message'=>'API này chỉ hỗ trợ phương thức PUT')));
    }
    $input = json_decode(file_get_contents('php://input'));
    if(is_null($input)){
        die(json_encode(array('code'=>2,'message'=>'Chỉ hỗ trợ JSON')));
    }
    if(!property_exists($input,'id') ){
        http_response_code(400);
        die(json_encode(array('code'=>1,'message'=>'Thiếu dữ liệu đầu vào')));
    }
    if(empty($input->id)){
        die(json_encode(array('code'=>1,'message'=>'Thông tin không hợp lệ')));
    }
    if(confirmUsers($conn,$input,2)['code']!=0){
        die(json_encode(array('code'=>1,'message'=>confirmUsers($conn,$input,1)['message'])));
    }
    die(json_encode(array('code'=>0,'data'=>confirmUsers($conn,$input,2)['message'])));


?>