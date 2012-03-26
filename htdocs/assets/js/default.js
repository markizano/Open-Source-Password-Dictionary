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


//http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js

/*
 @TODO: Here, I want to create an instance of the necessary library classes and begin the asynchronous
 communication stream. Only JSON will be transmitted. This framework will draw all HTML and render to
 the browser. I want this framework to be independent to the site, or at least encapsulate
 domain-specific logic to it's own components. Eventually, this framework will be versatile to pop into
 any site and instantly make it aesthetic as long as the server handles the requests appropriately.

 Here's a basic schematic on how a page sequence will proceed:
    - Start (User visits the site for the first time ever)
        - Bootstrap (Create required object instances and init data).
            - Keybindings: First overwrite arbitrary keybindings to keep the page safe.
            - Request/Response: Create AJAX request-response objects to speak to the server on command.
            - Registry/Config: Setup global options and store them for persistant usage while the user is on this page.
            - Timeouts: Setup all timers and kickoff all cron-based events.
            - Layout: Draw up the basic HTML structure that will pose as the layout for this site.
        - Determine the current request based on the params in the URL.
        - Fetch the request accordingly from the server.
        - Render the result on the page and return to even-based orientation.
        // ...
    - OnClose -
        - Shutdown
            - Clear cookies and session from the server.
            - Close all open external resources (shutdown hooks for plugins)
            - Close open windows.
            - End session.
    - End
*/

