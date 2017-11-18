<?php

Config::set('site_name', 'Your Site Name');

Config::set('languages', array('en', 'fr', 'ru', 'uk'));

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');