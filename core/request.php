<?php

namespace app\core;

class request
{

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';  // if not present path return '/'
        $position = strpos($path, '?');
        //strpos return postion  and start 0 not 1 
        // => 3andha 2 paramater 1parametre The string to search in. 
        // => 2parametre l7aga li an9lbo 3liha wast dik path 

        // var_dump($position); // return ch7al mn "charactere f url bi ?"
        // ex : users? return 6 ||| contactmove? return 11 

        if ($position === false) { // don't have query string in url
            return $path;
        }
        return substr($path, 0, $position); // wakha nktbo l query string yt7yd w yjib ghi li 9bl mno ex : users mn 0 7ta l 9bl (?)
    }
    public function getMethode()
    {
        return  strtolower($_SERVER['REQUEST_METHOD']); //strlower change charactere to lower case
    }
    public function getBody()
    {
        $body = [];
        if ($this->getMethode() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->getMethode() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
        }
        return $body;
    }
}
