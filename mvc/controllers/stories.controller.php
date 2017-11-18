<?php
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 18.11.2017
 * Time: 22:22
 */

class StoriesController extends Controller
{

    public function index()
    {
        $this->data['test_cat_content'] = 'Here will be a stories about cats';
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if ( isset($params[0]) ){
            $par = strtolower($params[0]);
            $this->data['cat_content'] = "Here is a story about a cat named'{$par}'";
        }
    }

}