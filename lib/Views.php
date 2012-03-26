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
 * Template class for all HTML printings. Separating the views from the models and controllers.
 *
 * @copyright  Copyright (c) 2012 #TheBlackMatrix
 * @author     Markizano Draconus <markizano@markizano.net>
 */
class Views
{
    public $decorator = 'default';
    public $errors = array();
    protected $_data = array();

    public function __get($a)
    {
        return isset($this->_data[$a]) ? $this->_data[$a]: null;
    }

    public function __set($a, $b = null)
    {
        return $this->_data[$a] = $b;
    }

    public function __isset($a)
    {
        return isset($this->_data[$a]);
    }

    public function __unset($a)
    {
        unset($this->_data[$a]);
    }

    /**
     * Goes at the top of the page.
     *
     * @return String
     */
    public static function header()
    {
        ob_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>#theblackmatrix Password List</title>
	</head>
	<body>
<?php
        return ob_get_clean();
    }

    /**
     * Goes at the bottom of the page...
     *
     * @return String
     */
    public static function footer()
    {
        ob_start();
?>
		<p>
			<a href="?action=raw&decorator=plain">Raw list (plain)</a><br />
			<a href="?action=raw&decorator=xml">Raw list (xml)</a><br />
			<a href="?action=raw&decorator=json">Raw list (json)</a><br />
		</p>
	</body>
</html>
<?php
        return ob_get_clean();
    }

    /**
     * Gets us the form we can print to add a new passwd.
     *
     * @return String
     */
    public function frmPassword()
    {
        ob_start();
?>
		<p>
			<h2>ADD A PASSWORD TO THE LIST</h2>
<?php
    if ( isset($this->errors) || !empty($this->errors) ) {
        print '<span class="error">' . join("</span><br />\n<span class='error'>", $this->errors) . '</span><br />' . PHP_EOL;
    }
?>
			<form action="" method="get">
			    <input type="hidden" value="add" name="action" />
				<input type="text" name="password" />
				<input type="submit" value="Add" />
			</form>
		</p>
<?php
        return ob_get_clean();
    }

    /**
     * Generates the output we'll render to the browser.
     *
     * @param Sring $decorator  The style of output you want for the password list.
     * @return String
     */
    public function render()
    {
        if ( !isset($this->password_list) || !is_array($this->password_list) ) {
            throw new RuntimeException("I can't render an empty password list...");
        }

        switch ($this->decorator) {
            case 'xml':
                isset($this->action) && $this->action == 'raw' && header('Content-Type: text/xml; charset=utf-8');
                $output = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n<password_list>\n"
                    . join(PHP_EOL, array_map(function($_pw) { // Needs to properly encode the contents.
                        $pw = '';
#                        for ($i = 0; $i < strlen($_pw); ++$i) {
#                            $pw .= sprintf('&#x%X;', ord($_pw{$i}));
#                        }
                        return "  <password><![CDATA[$_pw]]></password>";
                    }, $this->password_list)) . PHP_EOL
                    . '</password_list>' . PHP_EOL;
                break;

            case 'json':
                isset($this->action) && $this->action == 'raw' && header('Content-Type: application/json; charset=utf-8');
                $output = json_encode($this->password_list);
                break;

            case 'plain':
                isset($this->action) && $this->action == 'raw' && header('Content-Type: text/plain; charset=utf-8');
            default:
                $output = join(PHP_EOL, $this->password_list);
        }
        return $output;
    }

    /**
     * Render a string.
     *
     * @return String
     */
    public function __toString()
    {
        return $this->render();
    }
}

