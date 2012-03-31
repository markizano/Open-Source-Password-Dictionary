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

typeof(console) !== "undefined" && console.log("GO!"); //DEBUG

// jQuery should be included before we get this far (e.g. it should be in <head> before this is included)
// Intentionally stop here because it would be bad otherwise...
if (typeof(jQuery) === "undefined") { alert("I require jQuery ._."); return false; }

typeof(console) !== "undefined" && console.log("OK"); //DEBUG

(function ($) {
    // We should also have included the loader in <head> as well. It's the only crucial component to hardcode.
    typeof (ospd.Loader) !== "undefined";

    $(document).ready(function() {
        $(document.body).html("<div id='page'><span id='error'></span><br /><div id='content'></div></div>");
    });

})(jQuery);

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
                - document.unload(): Overload this to prevent the user from leaving the page without
                    explicit confirmation.
                - document.refresh(): Keep the user from pinging the server constantly.
                - document.history.go(): Overload the history searching for appropriate page viewing.
            - Request/Response: Create AJAX request-response objects to speak to the server on command.
            - Registry/Config: Setup global options and store them for persistant usage while the user is on this page.
            - Timeouts: Setup all timers and kickoff all cron-based events.
            - Layout: Draw up the basic HTML structure that will pose as the layout for this site.
                - HTML Structure from JSON-XSL translation.
                - CSS Manager. I believe there are libraries that support this.
            - Plugins: Need the ability to hook in modules to dynamically modify the page as we need
                for custom components of projects.
            - Controller: Load up the current controller handling this request.
        - Determine the current request based on the params in the URL.
        - Fetch the request accordingly from the server via controller calls to request-response modules.
        - Render the result on the page and return to even-based orientation.
        // ...
    - OnClose -
        - Shutdown
            - Clear cookies and session from the server.
            - Close all open external resources (shutdown hooks for plugins)
            - Close open windows.
            - End session.
    - End


 Components needed:
	Registry    : Global object for persisting objects and configurations across pageloads
		(e.g. the user leaves the site and comes back).
	Config      : Global per-request object for storing key-value config/option pairs.
	Loader      : Used for loading modules and objects dynamically from the server.
	Binder      : Base Object for managing major keybindings. It's role is similar to that of your 
		window manager; it will manage hotkeys/events dealing with the window, while each module can
		independently hold its own hotkey overrides/additions.
	Messaging   : For communicating messages with the end-user, the server, and a debug log somewhere...

*/

