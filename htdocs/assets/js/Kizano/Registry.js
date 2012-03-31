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

if ( typeof(ospd) === "undefined" ) { alert("Registry depends on ospd."); return false; }

/**
 * Responsible for static storage of the system. Every object will refer to this if they need to
 * persist data across requests. The data stored in this object is auto-synced with the server's
 * session and this object loads that data each time the page is loaded. Therefore, all options stored
 * by the object will persist across requests.
 * 
 * @TODO: Get this to communicate its needs to the server. Be sure to use the global config object
 *   for loading default options in case we have a fresh session on our plates.
 */
ospd.Registry = (function (options) {
    var self = {
    },
    _reg = {};

    self.set = function (id, value) {
        _reg[id] = value;
    };

    self.isset = function (id) {
        return (typeof (_reg[id]) !== "undefined");
    };

    self.get = function (id) {
        if (self.isset(id)) {
            return _reg[id];
        }
        return 
    };

    self.unset = function (id) {
        if ( self.isset(id) ) {
            delete _reg[id];
        }
    };

    // __call::__noSuchMethod__();
    return that;
});


