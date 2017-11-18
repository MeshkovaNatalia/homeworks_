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
    case 'add_category':
        addCategory($_POST);
    break;
    case 'edit_category':
        editCategory($_POST);
    break;
    case 'delete_category':
        deleteCategory($_POST);
    break;
    default:
    case 'default':
        displayAddCategoryForm();
        displayCategories();
        displayAddCategoryForm();
    break;
}
