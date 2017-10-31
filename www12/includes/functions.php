<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 11.10.2017
 * Time: 19:19
 */

$users = [
    ['login' => 'vasya', 'password' => 'NeSkazhu!987'],
    ['login' => 'petya', 'password' => 'Skazhu-Katom'],
];

$bLoggedIn = false;
if (!empty($_POST)) {
    if (isset($_POST['uname']) && isset($_POST['upass'])) {
        foreach ($users as $u) {
            if (($u['login'] == $_POST['uname'])
                && ($u['password'] == $_POST['upass'])
            ) {
                $_SESSION['u'] = $u['login'];
                $bLoggedIn = true;
                break;
            }
        }
        if (! $bLoggedIn) {
            echo 'Error: invalid user name or password<br>';
        } else {
            echo 'Welcome back, ' . $_SESSION['u'] . '<br>';
        }
    }
}

if (!empty($_SESSION['u'])) {
    $pages = [
        ['uri' => 'home', 'title' => 'Home page'],
        ['uri' => 'about', 'title' => 'About us'],
        ['uri' => 'gallery', 'title' => 'Gallery'],
        ['uri' => 'contact', 'title' => 'Contact us'],
        ['uri' => 'logout', 'title' => 'Exit'],
    ];
} else {
    $pages = [
        ['uri' => 'home', 'title' => 'Home page'],
        ['uri' => 'about', 'title' => 'About us'],
        ['uri' => 'contact', 'title' => 'Contact us'],
        ['uri' => 'login', 'title' => 'Log me in'],
    ];
}

function getNavigation() {
    global $pages;

    $sHavigation = '';
    if (!empty($pages)) {
        $curPage = 'home';
        if (isset($_REQUEST['page'])) {
            $curPage = $_REQUEST['page'];
        }
        $sHavigation .= '<nav><ul>';
        foreach ($pages as $page) {
            if ($curPage == $page['uri']) {
                $class = ' class="active"';
            } else {
                $class = '';
            }
            $sHavigation .= '<li><a' . $class . ' href="/index.php?page=' . $page['uri'] . '">' . $page['title'] . '</a></li>';
        }
        $sHavigation .= '</ul></nav>';
    }

    return $sHavigation;
}