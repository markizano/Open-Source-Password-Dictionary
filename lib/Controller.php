<?php
/**
 * 
 *  Open-Source Password Dictionary
 *  Copyright (C) 2012 #TheBlackMatrix
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
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

