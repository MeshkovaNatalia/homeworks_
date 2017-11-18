<?php

require_once 'inc' . DIRECTORY_SEPARATOR . 'session.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'functions.php';
require_once 'inc' . DIRECTORY_SEPARATOR . 'admin_functions.php';

dbConnect();

if (!isAdmin()) {
    header('/login.php');
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'default';

switch ($action) {
    case 'add_good':
        addGood($_POST);
    break;
    case 'edit_good':
        editGood($_POST);
    break;
    case 'delete_good':
        deleteGood($_POST);
    break;
    default:
    case 'default':
        displayAddGoodForm();
        displayGoods();
        displayAddGoodForm();
    break;
}
