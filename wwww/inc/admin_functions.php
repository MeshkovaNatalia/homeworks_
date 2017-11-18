<?php

function isAdmin()
{
    if (isset($_SESSION['u'])
    && $_SESSION['u']['is_admin'] == 1) {
        return true;
    }
    return false;
}

function displayAddCategoryForm()
{
    $html = '<form action="" method="post">
<div>
    <input type="text" name="name" placeholder="Category Name" maxlength="255">
</div>
<div>
    <textarea name="description" placeholder="Category Description"></textarea>
</div>
<div>
    <input type="text" name="image_url" placeholder="Image URL" maxlength="255">
</div>
<div>
    <input type="text" name="sort" placeholder="Sort order">
</div>
<div>
    <input type="checkbox" name="active" value="1" checked>
</div>
<div>
    <input type="submit" value="Add Category">
</div>
<input type="hidden" name="action" value="add_category">
</form>
';
    echo $html;
}

function addCategory($data)
{
    global $db;
    $name =  $db->real_escape_string(strip_tags(trim($data['name'])));
    $description = $db->real_escape_string(strip_tags(trim($data['description']), '<p><br><img><a>'));
    $image_url =  $db->real_escape_string(strip_tags(trim($data['image_url'])));
    $sort = intval($data['sort']);
    $active = intval($data['active']);

    $sql = "INSERT INTO `category`
SET
`name` = '{$name}',
`description` = '{$description}',
`image_url` = '{$image_url}',
`sort` = '{$sort}',
`active` = '{$active}'
";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    /*if ($res->insert_id) {
        echo 'Added new category #' . $res->insert_id;
    }*/
}

function displayCategories()
{
    $catHtml = '';
    global $db;
    $sql = "SELECT * FROM `category`";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    $category = [];
    while ($c1 = $res->fetch_assoc()) {
        $category[] = $c1;
    }
    if (!empty($category)) {
        $delim = '';
        foreach ($category as $c2) {
            $checked = '';
            if ($c2['active'] == 1) {
                $checked = ' checked';
            }
            $catHtml .= $delim . '<div><form action="" method="post">
<div>
    <input type="text" name="name" value="' . $c2['name'] . '" placeholder="Category Name" maxlength="255">
</div>
<div>
    <textarea name="description" placeholder="Category Description">' . $c2['description'] . '</textarea>
</div>
<div>
    <input type="text" name="image_url" value="' . $c2['image_url'] . '" placeholder="Image URL" maxlength="255">
</div>
<div>
    <input type="text" name="sort"  value="' . $c2['sort'] . '" placeholder="Sort order">
</div>
<div>
    <input type="checkbox" name="active" value="1" ' . $checked . '>
</div>
<div>
    <input type="submit" value="Update Category">
</div>
<input type="hidden" name="action" value="edit_category">
<input type="hidden" name="id" value="' . $c2['id'] . '">
</form>
<form action="" method="post">
<div>
    <input type="submit" value="Delete Category">
</div>
<input type="hidden" name="action" value="delete_category">
<input type="hidden" name="id" value="' . $c2['id'] . '">
</form></div>';
            $delim = '<hr>';
        }
    }
    echo $catHtml;
}

function editCategory($data)
{
    global $db;
    $name =  $db->real_escape_string(
        strip_tags(
            trim($data['name'])
        )
    );
    $description = $db->real_escape_string(strip_tags(trim($data['description']), '<p><br><img><a>'));
    $image_url =  $db->real_escape_string(strip_tags(trim($data['image_url'])));
    $sort = intval($data['sort']);
    $active = intval($data['active']);
    $id = intval($data['id']);

    $sql = "UPDATE `category`
SET
`name` = '{$name}',
`description` = '{$description}',
`image_url` = '{$image_url}',
`sort` = '{$sort}',
`active` = '{$active}'
WHERE `id` = '{$id}'
";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
}

function deleteCategory($data) {
    global $db;
    $id = intval($data['id']);
    $sql = "DELETE FROM `category` WHERE `id` = '{$id}' LIMIT 1";
    $res = $db->query($sql);
}

function displayAddGoodForm() {

}

function getCategorySelect($selectedId) {
    global $db;
    $sql = "SELECT * FROM `category`";
    $res = $db->query($sql);
    $html = '<select name="category_id">';
    while ($c1 = $res->fetch_assoc()) {
        $selected = '';
        if ($selectedId == $c1['id']) {
            $selected = ' selected';
        }
        $html .= '<option value="' . $c1['id'] . '"' . $selected . '>' . $c1['name'] . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function displayGoods() {
    global $db;
    $sql = "SELECT g.* FROM `goods` g ORDER BY g.`id` ASC";
    $res = $db->query($sql);
    if ($db->error) {
        die('Error #' . $db->errno . ': ' . $db->error);
    }
    $goods = [];
    while ($g1 = $res->fetch_assoc()) {
        $goods[] = $g1;
    }
    $goodsHtml = '';
    if (!empty($goods)) {
        foreach ($goods as $g2) {
            $checked = '';
            if ($g2['active'] == 1) {
                $checked = ' checked';
            }
            $goodsHtml .= '<div><form action="" method="post">
<div>' . getCategorySelect($g2['category_id']) . '</div>
<div>
    <input type="text" name="title" value="' . $g2['title'] . '" placeholder="Product Title" maxlength="255">    
</div>
<div>
    <textarea name="description" placeholder="Product Description">' . $g2['description'] . '</textarea>
</div>
<div>
    <input type="text" name="image_url" value="' . $g2['image_url'] . '" placeholder="Image URL" maxlength="255">
</div>
<div>
    <input type="text" name="price"  value="' . $g2['price'] . '" placeholder="$ Price">
</div>
<div>
    <input type="checkbox" name="active" value="1" ' . $checked . '>
</div>
<input type="hidden" name="id" value="' . $g2['id'] . '">
</form></div>';
        }
    }
    echo $goodsHtml;
}

function addGood($data) {

}

function editGood($data) {

}

function deleteGood($data) {

}