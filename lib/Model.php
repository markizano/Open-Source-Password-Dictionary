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

defined('_EXEC') or die(header('HTTP/1.1 404') . <<<HEADER
<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL $_SERVER[REQUEST_URI] was not found on this server.</p>
</body></html>
HEADER
);

/**
 * Handles the heavy lifting, validations, and filterings for all data.
 */
class Model
{
    /**
     * Holds the location to our current DB file instance.
     *
     * @var String
     */
    protected $_db_file;
    protected $_dict = array();

    public function __construct()
    {
        $this->_db_file = DB_DIR . DS . 'default.db';
        $this->verifyDb();
        $this->fetchDb(); // Prep the DB for later use.
    }

    public function __destruct()
    {
        sort($this->_dict);
        $this->saveDb();
        unset($this->_dict, $this->_db_file);
    }

    /**
     * Gets the current DB file.
     *
     * @return String
     */
    public function getDbFile()
    {
        return $this->_db_file;
    }

    /**
     * Assigns a new DB file safe for use.
     *
     * @param String    $db_file    The new DB file to assign. Beware, we will basename() this!
     * @return Models
     */
    public function setDbFile($db_file)
    {
        if ( !is_string($db_file) ) {
            throw new RuntimeException('Endsure argument 1($db_file) is a string.');
        }

        $this->_db_file = DB_DIR . DS . basename($db_file);
        return $this;
    }

    /**
     * Verifies the database will exists and is writable.
     *
     * @return True
     * @throws RuntimeException
     */
    public function verifyDB()
    {
        if ( !is_writable(BASE_DIR) || !is_writable(BASE_DIR) ) {
            // The developer must ensure we can read/write to this directory.
            $apache = posix_getpwuid(posix_getuid());
            throw new RuntimeException("Please ensure `$apache[name]' has write access to " . BASE_DIR);
        }

        if ( !file_exists(DB_DIR) ) {
            mkdir(DB_DIR, 0755);
        }

        if ( !file_exists($this->_db_file) ) {
            touch($this->_db_file, time());
        }

        return true;
    }

    /**
     * Adds a password to the dictionary
     *
     * @return Models
     */
    public function add($pw)
    {
        if ( !is_string($pw) || empty($pw) ) {
            throw new InvalidArgumentException('Argument 1($pw) must be a non-empty string.');
        }

        if ( in_array($pw, $this->_dict) ) {
            return false;
        }

        $this->_dict[] = $pw;
        return $this;
    }

    /**
     * Fetches us the database and loads it into the class for manipulation.
     *
     * @return Array
     */
    public function fetchDb()
    {
        empty($this->_dict) && $this->_dict = file($this->_db_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        return $this->_dict;
    }

    /**
     * Saves the database to file.
     *
     * @return Models
     */
    public function saveDb()
    {
        file_put_contents($this->_db_file, join(PHP_EOL, $this->_dict));
        return $this;
    }
}

