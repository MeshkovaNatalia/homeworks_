<?php
/**
 * Created by PhpStorm.
 * User: Тарас
 * Date: 13.11.2017
 * Time: 20:53
 */

class NewsController extends Controller
{
    public function index()
    {
        $this->data['news_content'] = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. ' .
            'Accusamus aspernatur, consectetur delectus dolorum eaque eligendi facilis in labore ' .
            'necessitatibus neque odit praesentium provident quasi. Dolorum repudiandae sed sint soluta unde.';
    }

    public function view()
    {
        $params = App::getRouter()->getParams();

        if ( isset($params[0]) ){
            $alias = strtolower($params[0]);
            $this->data['news_content123'] = "Here will be a news with '{$alias}' alias";
        }
    }
}