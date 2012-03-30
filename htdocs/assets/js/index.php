<?php
/**
 *  Open-Source Password Dictionary
 *  Copyright (c) 2012, <#TheBlackMatrix>
 *  All rights reserved.
 *  
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 *      * Redistributions of source code must retain the above copyright
 *        notice, this list of conditions and the following disclaimer.
 *      * Redistributions in binary form must reproduce the above copyright
 *        notice, this list of conditions and the following disclaimer in the
 *        documentation and/or other materials provided with the distribution.
 *      * Neither the name of the <organization> nor the
 *        names of its contributors may be used to endorse or promote products
 *        derived from this software without specific prior written permission.
 *  
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 *  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 *  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *  DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 *  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 *  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 *  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 *  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 */

/*
isset($_SERVER['HTTP_X_REQUESTED_WITH']) or die(header('HTTP/1.1 404') . <<<HEADER
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL $_SERVER[REQUEST_URI] was not found on this server.</p>
</body></html>
HEADER
);
//*/

ini_set('html_errors', false);

/**
 * JavaScriptResource. Fetches files based on a class name and prints them for inclusion on the client.
 */
class JSR
{
    /**
     * A class must start with a letter or a number. Then, the only characters that may follow are:
     *   - Alphanumeric (A to Z and 0 to 9)
     *   - Underscores ( _ )
     *   - Periods ( . )
     *   - Commas ( , )
     * Once the class name is verified, we check to see if the file exists. If these conditions are
     * met, the class name is valid. False, otherwise.
     * 
     * @param String    $class  The class name to check against.
     * @return boolean
     */
    public static function isValidClassName($class)
    {
        return preg_match('/^[0-9A-Za-z][0-9A-Za-z_.,]+$/i', $class) && file_exists(self::translateClassName($class));
    }

    /**
     * Converts the class name into something we can read from disk.
     *
     * @param String    $class      The class name to translate.
     * @return String
     */
    public static function translateClassName($class)
    {
        return dirname(__FILE__) . '/' . str_replace('.', '/', $class) . '.js';
    }

    /**
     * JS-Minifies a file.
     *
     * @param String  $file  The file to load.
     * @return String
     */
    public static function jsmin_file($file)
    {
        return trim(jsmin(file_get_contents($file)));
    }

    /**
     * Entry point.
     *
     * @param String    $_class     The class(es) to load.
     * @return void
     */
    public static function main($_class)
    {
        header('Content-Type: application/x-javascript; charset=utf-8');
        $jsr = new JSR;

        foreach (explode(',', $_class) as $class) {
            if (JSR::isValidClassName($class)) {
                print JSR::jsmin_file(JSR::translateClassName($class));
            } else {
                header('HTTP/1.1 404 Not Found');
                print json_encode(array(
                    'error' => 'Invalid Class Name',
                    // There may be more info to add here.
                ));
            }
        }
    }
}

JSR::main(isset($_GET['class']) ? $_GET['class'] : null);

