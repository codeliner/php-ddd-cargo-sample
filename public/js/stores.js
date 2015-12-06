var Resource = (function () {
    var Resource = function (id, name, data) {
        var self = this;

        self.getId = function () {return id};
        self.getName = function () {return name};
        self.getProp = function(prop) {
            return data[prop]? data[prop] : null;
        }
        self.setProp = function(prop, val) {
            data[prop] = val;
        }

        self.getProps = function () {
            return data;
        }
    }

    return Resource;
})();

var LocationStore = (function ($, _, Q, Resource) {
    var LocationStore = function () {
        var self = this;
        var _locations = [];

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
