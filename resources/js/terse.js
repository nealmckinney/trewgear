(function (global) { /* jason sebring invention, mail@jasonsebring.com */
    global.terse = global.terse || function (input) {
        var stack = [],
        oa = function (n, z) {
            t.context[n] = t.context[n] || z;
            stack.push(t.context);
            t.context = t.context[n];
            return t;
        },
        t = {
            context: (function () {
                var theType = Object.prototype.toString.call(input);
                switch (theType) {
                    case '[object String]':
                        window[input] = window[input] || ((arguments.length > 1) ? arguments[1] : {});
                        return window[input];
                    case '[object Object]': return input;
                    case '[object Array]': return input;
                    default: throw 'input must be of type String, Object or Array';
                }
            })(),
            obj: function (n) { return oa(n, {}); },
            set: function (m) { m(t.context); return t; },
            arr: function (n) { return oa(n, []); },
            prop: function (n, z) { t.context[n] = t.context[n] || z; return t; },
            map: function (o) {
                var i; for (i in o) { t.context[i] = o[i]; }
                return t;
            },
            end: function () {
                var v = stack.pop();
                if (v) { t.context = v; }
                return t;
            }
        };
        return t;
    };
})(this);