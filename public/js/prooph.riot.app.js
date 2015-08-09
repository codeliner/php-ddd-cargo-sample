
var ProophRouter = (function(riot, _) {
    var ProophRouter = function (routePath, routerStack) {
        var self = this;
        var _routePath = routePath;
        var _routerStack = routerStack;

        riot.observable(self);

        self.getRoutePath = function () {
            return _routePath;
        }

        self.stop = function () {
            riot.route.stop();
        }

        self.restart = function () {
            riot.route.start();
        }

        self.get = function (path) {
            var currentPath = _routePath.join("/");

            if (!path) return '#' + currentPath;

            return '#' + (currentPath? currentPath + "/" : "") + path;
        }

        self.getSubRouter = function (subRoute) {
            if (!_.isString(subRoute) || _.isEmpty(subRoute)) {
                throw new Error("Cannot sub route an empty sub route!");
            }
            var subRoutePath = _.slice(_routePath, 0);

            subRoutePath.push(subRoute);

            return routerStack.getRouterForRoutePath(subRoutePath);
        }

        self.route = function (routeMatch, context) {
            var _routeMatch = _.slice(routeMatch, 0);

            _.forEach(_routePath, function (part) {
                var rmPart = _routeMatch.shift();

                if (rmPart != part) {
                    _routeMatch.unshift(rmPart);
                }
            });

            context["routeMatch"] = _routeMatch;
            context["router"] = self;

            self.trigger("route", context);
        }

    };

    return ProophRouter;
}(riot, _));

var ProophRouterStack = (function(_, Router){

    var ProophRouterStack = function () {
        var self = this,_stack = {}, _routePathToIndex = function (routePath) {
            return '#' + routePath.join("/");
        };

        self.getRouterForRoutePath = function (routePath) {
            if (!_.isArray(routePath)) {
                throw new Error("routePath must be an array. Got " + JSON.stringify(routePath));
            }

            var index = _routePathToIndex(routePath);

            if (! self.hasRouterForRoutePath(routePath)) {
                _stack[index] = new Router(routePath, self);
            }

            return _stack[index];
        }

        self.hasRouterForRoutePath = function (routePath) {
            if (!_.isArray(routePath)) {
                throw new Error("routePath must be an array. Got " + JSON.stringify(routePath));
            }

            var index = _routePathToIndex(routePath);

            return !!_stack[index];
        }

        self.matchNearestRouter = function(routePath) {
            var _routePath = _.slice(routePath, 0);

            if (self.hasRouterForRoutePath(_routePath)) {
                return self.getRouterForRoutePath(_routePath);
            }

            while (_routePath.length > 0) {
                _routePath.pop();

                if (self.hasRouterForRoutePath(_routePath)) {
                    return self.getRouterForRoutePath(_routePath);
                }
            }

            return self.getRouterForRoutePath([]);
        }

        self.removeRouter = function (router) {
            var index = _routePathToIndex(router.getRoutePath());

            delete _stack[index];
        }
    };

    return ProophRouterStack;
}(_, ProophRouter));

var ProophRiotRouterBridge = (function(_){
    var ProophRiotRouterBridge = function (app, routerStack) {
        var self = this,
            _app = app,
            _routerStack = routerStack,
            _onRoute = function () {
                var _routeMatch = _.slice(arguments, 0);

                if (_routeMatch.length == 1 && _routeMatch[0] == "") {
                    _routeMatch.shift();
                }

                var _nearestRouter = _routerStack.matchNearestRouter(_routeMatch);

                _nearestRouter.route(_routeMatch, {app : _app});
            };

        self.attachTo = function(riot) {
            riot.route(_onRoute);
        }

        self.exec = function(riot) {
            riot.route.exec(_onRoute);
        }
    }

    return ProophRiotRouterBridge;
}(_));


var ProophRiot = (function(riot, _, $, RouterStack, RiotRouterBridge){
    var ProophRiot = {},
        _AppPrototype = function (mixins) {

            if (!mixins) mixins = {};

            var self = this,
                _routerStack = new RouterStack(),
                _routerBridge = new RiotRouterBridge(self, _routerStack);

            riot.observable(self);

            _.assign(self, mixins);

            _routerBridge.attachTo(riot);

            self.bootstrap = function (rootTag) {
                riot.mount(rootTag, {app: self, router: _routerStack.getRouterForRoutePath([])});
                return self;
            };

            self.renderInto = function (parentTag, into, tag, mixins) {

                if (!mixins) mixins = {};

                var node = $(parentTag.root).find(into).html($('<' + tag + ' />')).find(tag).get(0);

                if (node) {
                    riot.mountTo(node, tag, _.assign({app : self, router : _routerStack.getRouterForRoutePath([])}, mixins));
                }
            }

            self.ready = function () {
                this.trigger("ready", {app : self, router : _routerStack.getRouterForRoutePath([])});

                _routerBridge.exec(riot);
            }

            self.hasRouterForRoutePath = function(routePath) {
                return _routerStack.hasRouterForRoutePath(routePath);
            }

            self.removeRouterForRoutePath = function(routePath) {
                if (_routerStack.hasRouterForRoutePath(routePath)) {
                    var router = _routerStack.getRouterForRoutePath(routePath);
                    _routerStack.removeRouter(router);
                }
            }
        };

    ProophRiot.App = {
        create : function (config) {
            return new _AppPrototype(config);
        }
    }

    ProophRiot.namespace = function(name){
        var parts = name.split('.');
        var current = ProophRiot;
        for (var i in parts) {
            if (!current[parts[i]]) {
                current[parts[i]] = {};
            }

            current = current[parts[i]];
        }
    },
    ProophRiot.Helpers = {
        merge_tag_elements_with_obj : function(tag, obj) {
            _.forIn(obj, function (value, key) {
                if (_.has(this, key)) {
                    this[key].value = value;
                }
            }, tag);
        },
        form_to_plain_obj : function (formEl) {
            return _.mapValues(
                _.indexBy($(formEl).serializeArray(), "name"),
                function (valObj) {
                    return valObj.value;
                }
            )
        }
    }

    return ProophRiot;
}(riot, _, jQuery, ProophRouterStack, ProophRiotRouterBridge));

/*
//In browser tests, uncomment if routing does not work
var stack = new ProophRouterStack();

var rootRouter = stack.getRouterForRoutePath([]);

rootRouter.on("route", function (context) {
    console.log("Root route is invoked with context: ", context);
});

console.log("Booking route: ", rootRouter.get("booking"));

var bookingRouter = rootRouter.getSubRouter("booking");

bookingRouter.on("route", function (context) {
    console.log("Booking  route is invoked with context: ", context);
});

console.log("Cargos route: ", bookingRouter.get("cargos"));
console.log("Cargos add route derived from BookingRouter: ", bookingRouter.get("cargos/add"));

var cargosRouter = bookingRouter.getSubRouter("cargos");

cargosRouter.on("route", function (context) {
    console.log("Cargos  route is invoked with context: ", context);
});

console.log("Cargos add route dervied from CargosRouter: ", cargosRouter.get("add"));
console.log("Cargos router route path: ", cargosRouter.getRoutePath());

var nearestRouter = stack.matchNearestRouter(["booking", "sub", "path"]);

console.log("Nearest router for booking and unknown path: ", nearestRouter.getRoutePath());

stack.removeRouter(cargosRouter);

nearestRouter = stack.matchNearestRouter(["booking", "cargos", "add"]);

console.log("Nearest router for booking after cargos router was removed: ", nearestRouter.getRoutePath());

var routerBridge = new ProophRiotRouterBridge({getStore : function () {}}, stack);

routerBridge.attachTo(riot);

routerBridge.exec(riot);
*/