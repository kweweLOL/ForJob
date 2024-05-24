<?
if(isset($_POST)) {
    echo bin2hex(random_bytes(6));
}