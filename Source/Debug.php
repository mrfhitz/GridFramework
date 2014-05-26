<?php

/**
 * Class Debug
 */
class Debug {
    private static  $_counter,
                    $_errors;

    /**
     * Allow Debugger to catch all the bug's
     */
    public static function enableDebug(){
        self::$_errors = array();
        self::$_counter = 0;

        set_error_handler('Debug::debuging_error_handler', E_ALL | E_RECOVERABLE_ERROR | E_USER_NOTICE | E_USER_WARNING | E_USER_ERROR | E_NOTICE | E_WARNING);
        set_exception_handler('Debug::exception_handler');
    }

    public static function debuging_error_handler($errno, $errstr, $errfile, $errline) {
        $e = '';
        switch ($errno) {
            case E_USER_WARNING:
                $e .= "WARNING(<b>line {$errline}</b>): {$errstr} at <i>$errfile</i>";
                break;

            default:
                $e .= "ERROR(<b>line {$errline}</b>): {$errstr} at <i>$errfile</i>";
                break;
        }

        self::$_errors[] = $e;
    }

    public static function exception_handler($exception) {
        self::$_errors[] = "ERROR: " . $exception->getMessage();
        self::showAll();
    }

    /**
     * Scream some text on the screen!
     * @param some debug text or just empty.
     */
    public static function scream($text = '') {
        if(isset(self::$_counter)){
            echo '<p class="debug_scream">' . '<strong>DEBUG ('. self::$_counter .') </strong>' . $text . '</p>';
            self::$_counter++;
        }
    }

    /**
     * Show all the bugs on the screen!
     */
    public static function showAll(){
        if(isset(self::$_counter)): ?>
            <div id="debug_handler" onload="startCommandLine();">
                <div id="command_line"><strong class="title">DEBUG CONSOLE:</strong>
                    <input type="text" id="debug_command" name="command" autocomplete="off"><span class="prompt">></span>
                    <small>Status: <span id="debug_status">OFF</span></small>
                </div>
                <div id="all_commands"></div>
                    <?php foreach(self::$_errors as $err)
                            echo '<p>' . $err . '</p>';
                    ?>
            </div>
        <?php endif;
    }
}