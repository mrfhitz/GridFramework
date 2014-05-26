<?php
class TextHandler {
    public static function escape($str) {
        return preg_replace('/[^\w]/?<>','',$str);
    }
}