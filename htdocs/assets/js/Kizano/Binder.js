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

if (typeof (ospd) === "undefined") { alert("Loader depends on ospd."); return false; }

/**
 * Handles the binding of keys to the window. Global functions go here only!
 */
ospd.Binder = (function ($) {
    var self = {}, /*private*/ that = {
    	funcs: [
        	'load',
            'unload',
            'refresh',
            'history',
    	]
    };

    self.load = function () {
        // SIGINIT;
        // Preload all classes necessary for single-page execution here.
        // Create instances and assign to the registry.
        // Fire preloader hooks for each plugin loaded.
    };

    self.unload = function () {
        // Find the message system and send a signal SIGTERM.
        return false;
    };

    self.refresh = function () {
        // Find a message system and send a signal SIGHUP.
        return false;
    };

    self.history = function (dir) {
        // Send a signal SIGNAV, offset (dir).
        return false;
    };

    self.init = function () {
        var i;

		$(that.funcs).each(function (i, func) {
			$(document).bind(func, self[func]);
		});

        for (i in that.funcs) {
            $(document).bind(that.funcs[i], self[that.funcs[i]]);
        }

        history.go = self.navigate;

        return self;
    }

    $(document).ready(self.init);
    return self;
})(jQuery);


