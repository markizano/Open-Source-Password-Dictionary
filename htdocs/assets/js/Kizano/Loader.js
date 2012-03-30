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

if (typeof (Kizano) === "undefined") { alert("Loader depends on Kizano."); return false; }
if (typeof (jQuery) === "undefined") { alert("Loader depends on jQuery."); return false; }

/**
 * Loader class to pull this whole thing together. This object holds methods of determining if
 * something is available in the system, and also fetching resources from the server to import them
 * into the system.
 */
Kizano.Loader = (function ($) {
    var
        self = {},
        /*private*/ that = {
            cache: {},
        };

    self.exists = function (target) {
        if ( typeof (target) === "undefined" ) { return false; }
        var a, c, gl;

        // Define a list of global variables to check.
        gl = [window, document, navigator, Kizano];
        // First, determine the contents of the loop.
        if ( typeof (target) == "string" && target.indexOf(".") !== -1 ) {
            for (var i in gl) {
                for ( a = target.split(/\./g), Kiz = gl[i], c = a.shift(); a.length > 0; Kiz = Kiz[c], c = a.shift() ) {
//console.log({ t: Kiz[c], Kiz: Kiz, i: i, c: c, a: a });
                    if ( typeof(Kiz[c]) === "undefined") {
                        return false;
                    }
                }

                // If we iterated without a hitch, then the target must exist.
                return (typeof(Kiz[c]) !== "undefined");
            }

            return false; // If we iterate as deep as provided, then it doesn't exist.
        } else {
            for (var i in gl) {
                // In the case we're passed an object test case.
                if ( typeof (gl[i][target]) !== "undefined" ) { return true; }
            }
        }

        return false;
    };

    self.request = function (target) {
        if ( self.exists(target) ) {
            return typeof (target) === "string"? eval(target): target;
        }

        $.ajax({
            url: '/assets/js/',
//            url: '/debug.php',
            contentType: 'application/json',
            context: target,
            statusCode: {
                403: function () {
                    typeof (console) !== "undefined" && console.log("403 Forbidden");
                },
                404: function () {
                    typeof (console) !== "undefined" && console.log("404 Not Found.");
                },
                500: function () {
                    typeof (console) !== "undefined" && console.log("500 Server Error.");
                }
            },
            data: {
                'class': target
            }
        })
        .success(that.response)
        .error(function(jqXHR, status, e){
            $('#error').append('Failed requesting class ' + this);
            if ( typeof(console) !== "undefined" ) {
                console.log("ERROR!");
                console.log({
                    jqXHR: jqXHR,
                    status: status,
                    error: e,
                });
            }
        })
        .complete(function(jqXHR, status) {
            console.log("COMPLETE!");
            if (status === "success") {
                eval(jqXHR.responseText);
                $('#content').append('Loaded class: ' + this + '<br />\n');
            }

            console.log({
                jqXHR: jqXHR,
                stat: status
            });
        });
    };

    self.load = function (target) {
        if (self.exists(target.replace(/\x2F/g, "."))) { return that; }
        return self.request(target);
    };


    return self;
})(jQuery);

var use = function (target) {
    return Kizano.Loader.load(target);
};

/*
  ok(use("Kizano.Registry"));
  ok(use(["Kizano.View", "Kizano.Layout"]));
*/

/*jslint bitwise: true, browser: true, sloppy: false, evil: true, plusplus: true, maxerr: 50, indent: 4 */
