<?php

if(isset($_POST)) {

    $data = file_get_contents('data.json');

    echo $data;
}