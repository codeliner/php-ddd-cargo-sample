var Resource = (function () {
    var Resource = function (id, name, data) {
        var self = this;

        self.getId = function () {return id};
        self.getName = function () {return name};
        self.get = function(prop) {
            return data[prop]? data[prop] : null;
        }
        self.set = function(prop, val) {
            data[prop] = val;
        }

        self.getProps = function () {
            return data;
        }
    }

    return Resource;
})();

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
                return Q($.getJSON('/api/locations')).then(function (data) {

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
            $.postJSON('/api/cargos', {
                origin: cargoData.origin,
                destination: cargoData.destination
            }).then(function(data){
                var cargo = new Resource(data.trackingId, 'cargo', cargoData);
                app.trigger("cargo_created", cargo);
            }, $.failNotify);
        });

        app.on('refresh_cargo', function(data) {
            $.getJSON('/api/cargos/' + data.id).then(function(data) {
                var cargo = new Resource(data.tracking_id, 'cargo', data);

                app.trigger('cargo_refreshed', cargo);
            }, $.failNotify);
        });

        self.getAll = function () {
            var _cargos = [];

            return Q($.getJSON('/api/cargos')).then(function (data) {

                _.each(data.cargos, function (cargoData) {
                    _cargos.push(new Resource(cargoData.trackingId, 'cargo', cargoData))
                });

                return _cargos;
            });
        }


    }

    return CargoStore;
})(jQuery, _, Q, Resource);
