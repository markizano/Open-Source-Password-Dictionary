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

define('DS', DIRECTORY_SEPARATOR);
define('BASE_DIR', dirname(__FILE__));
define('DB_DIR', BASE_DIR . DS . 'db');

# Ensure we can properly include our libraries.
set_include_path( join( PATH_SEPARATOR, array(BASE_DIR, get_include_path()) ) );

