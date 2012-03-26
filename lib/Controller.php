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
 * Directs traffic and avoids accidents. Go, police-man, go!
 */
class Controller
{
    /**
     * Holds the current action to take.
     *
     * @var String
     */
    public $action = 'list';
    private $_model,
        $_view;

    /**
     * Gets us a new instance of the controller for us and handles a few internal things.
     *
     * @return void
     */
    public function __construct()
    {
        isset($_GET['action']) && $this->action = strToLower($_GET['action']);
        $this->_model = new Model;
        $this->_view = new Views;
        isset($_GET['decorator']) && $this->_view->decorator = (string)$_GET['decorator']; // Don't inject arrays, please.
    }

    /**
     * Executes the action of moving data in place on the stage, then rendering it in the view.
     *
     * @return Controller
     */    
    public function run()
    {
        switch ($this->action) {
            case 'add':
                if ( !isset($_GET['password']) || empty($_GET['password']) ) {
                    $this->_view->errors[] = "I need a password to enter.";
                }

                if ( !$this->_model->add($_GET['password'])) {
                    $this->_view->errors[] = "I already have that password.";
                }

                if ( empty($this->_view->errors) ) {
                    header('Location: ' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
                    return $this;
                }

                print Views::header()
                    . $this->_view->frmPassword()
                    # Do we really want to render the list here?
                    #. '<pre>' . htmlEntities($this->_view->render(), ENT_QUOTES, 'utf-8') . '</pre>' . PHP_EOL
                    . Views::footer();
                return $this; // break; intentionally ommited. We don't need it if we're breaking from the function entirely...

            case 'raw':
                $this->_view->password_list = $this->_model->fetchDb();
                print $this->_view->render() . PHP_EOL;
                break;

            case 'list':
            default:
                # Only render the first 100 until we get pagination in place.
                $this->_view->password_list = array_slice($this->_model->fetchDb(), 0, 100);
                print Views::header()
                    . $this->_view->frmPassword()
                    . '<pre>' . htmlEntities($this->_view->render(), ENT_QUOTES, 'utf-8') . '</pre>' . PHP_EOL
                    . Views::footer();
        }

        return $this;
    }
}

