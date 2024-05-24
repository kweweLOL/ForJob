<?php

if(isset($_POST)) {

    $data = $_POST;

    $writeInJSON = json_encode($_POST);
    file_put_contents('data.json',$writeInJSON);
    
    print_r($data);
}