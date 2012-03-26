/**
 * 
 *  Registry
 *  Copyright (C) 2012  Markizano Draconus <markizano@markizano.net>
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

if ( typeof(Kizano) === "undefined" ) { alert("Registry depends on Kizano."); quit(); }

Kizano.Registry = (function (options) {
    var that = {
        _reg: {},
        set: function (id, value) {
            this._reg[id] = value;
        },
        isset: function (id) {
            return (typeof (this._reg[id]) !== "undefined");
        }
    };

    that.get = function (id) {
        if (that.isset(id)) {
            return this._reg[id];
        }
        return 
    };

    that.unset = function (id) {
        if ( that.isset(id) ) {
            delete this._reg[id];
        }
    };

    // __call::__noSuchMethod__();
    return that;
});

