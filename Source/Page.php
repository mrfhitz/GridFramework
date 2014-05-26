<?php

/**
 * Class Page
 */
class Page {
    /**  @var string */
    private static $separator = '/';
    /**  @var string */
    private static $prefix = 'p';

    /**
     * Search parameters in 'p' by the method _GET;
     * Can return page subpage subsubpage ... inside array.
     * @return false if empty or array of pages if can get the page
     */
    public static function getPage(){
        if(isset($_GET[self::$prefix])){
            $page = $_GET[self::$prefix];
            if(!empty($page) AND $page != "index.php"){
                $page = rtrim($page, self::$separator);
                return explode(self::$separator, $page)[0];
            }
        }
        return false;
    }

    public static function getSubPage(){
        if(isset($_GET[self::$prefix])){
            $page = $_GET[self::$prefix];
            if(!empty($page) AND $page != "index.grid"){
                $page = rtrim($page, self::$separator);
                $page = explode(self::$separator, $page);
                if(count($page) > 1)
                    return $page[1];
            }
        }
        return false;
    }


    /**
     * Make URL based on 2 layers of pages.
     * @param $page
     * @param $subpage or null
     * @return subpage URL
     */
    public static function composeURL($page, $subpage = null){
        if($page and $subpage){
            return $page . self::$separator . $subpage;
        }else if($page){
            return $page;
        }

        return false;
    }

}