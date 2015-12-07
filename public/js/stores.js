var Resource = (function () {
    var Resource = function (id, name, data) {
        var self = this;

        self.getId = function () {return id};
        self.getName = function () {return name};
        self.get = function(prop) {
            return data[prop]? data[prop] : null;
        };
        self.getProps = function () {
            return data;
        }
    }

    return Resource;
})();

var ChildResource = (function (Resource) {
    var ChildResource = function (parent, id, name, data) {
        var self = this;

        if (! parent instanceof Resource) {
            throw new Error("Parent of child resource" + name + " must be of type Resource");
        }

        self.getParentName = function () {return parent.getName()};
        self.getParentId = function() {return parent.getId()};
        self.getParent = function() {return parent};
        self.getId = function () {return id};
        self.getName = function () {return name};
        self.get = function(prop) {
            return data[prop]? data[prop] : null;
        };
        self.getProps = function () {
            return data;
        }
    }

    return ChildResource;
})(Resource);

var LocationStore = (function ($, _, Q, Resource) {
    var LocationStore = function (app) {
        var self = this;
        var _locations = [];

        app.on("refresh_locations", function () {
            self.getAll().then(function() {
                app.trigger("locations_refreshed", _locations);
            }, $.failNotify).done();
        });

        self.getAll = function () {
            if (_.isEmpty(_locations)) {
                return Q($.getJSON(app.config.url.forResourceCollection('location'))).then(function (data) {

                    _.each(data.locations, function (locationData) {
                        _locations.push(new Resource(locationData.unLocode, 'location', locationData))
                    });

                    return _locations;
                });
            } else {
                return Q.fcall(function () {
                    return _locations;
                });
            }
        }
    }

    return LocationStore;
})(jQuery, _, Q, Resource);

var CargoStore = (function ($, _, Q, Resource) {
    var CargoStore = function (app) {
        var self = this;

        app.on('create_cargo', function(cargoData) {
            $.postJSON(app.config.url.forResourceCollection('cargo'), {
                origin: cargoData.origin,
                destination: cargoData.destination
            }).then(function(data){
                var cargo = new Resource(data.trackingId, 'cargo', cargoData);
                app.trigger("cargo_created", cargo);
            }, $.failNotify);
        });

        app.on('refresh_cargo', function(cargo) {
            $.getJSON(app.config.url.forResource(cargo)).then(function(data) {
                var cargo = new Resource(data.tracking_id, 'cargo', data);

                app.trigger('cargo_refreshed', cargo);
            }, $.failNotify);
        });

        app.on('assign_route_candidate_to_cargo', function(routeCandidate) {
            var cargo = routeCandidate.getParent();
            $.putJSON(app.config.url.forResource(cargo), routeCandidate.getProps()).then(function(data) {
                var cargo = new Resource(data.tracking_id, 'cargo', data);
                app.trigger('cargo_refreshed', cargo);
            }, $.failNotify)
        })

        app.on('refresh_cargo_list', function() {
            $.getJSON(app.config.url.forResourceCollection('cargo')).then(function (data) {
                var cargos = [];
                _.each(data.cargos, function (cargoData) {
                    cargos.push(new Resource(cargoData.tracking_id, 'cargo', cargoData))
                });

                app.trigger('cargo_list_refreshed', cargos);
            }, $.failNotify);
        })
    }

    return CargoStore;
})(jQuery, _, Q, Resource);

var RouteCandidateStore = (function($, _, Q, Resource){
    var RouteCandidateStore = function(app) {
        var self = this;

        app.on('load_cargo_routecandidates', function(cargo) {
            if (! cargo instanceof Resource) {
                throw new Error("Cargo must be an instance of Resource");
            }

            $.getJSON(app.config.url.forChildResourceCollection(cargo, 'routecandidate')).then(function(data) {
                var candidates = [];

                _.each(data.routeCandidates, function(candidateData) {
                    candidates.push(new ChildResource(cargo, candidateData.id, 'routecandidate', candidateData));
                });
                app.trigger('cargo_routecandidates_loaded', candidates);
            }, $.failNotify);
        })
    }

    return RouteCandidateStore;
})(jQuery, _, Q, Resource);
