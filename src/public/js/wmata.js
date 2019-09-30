/**
 * In a full app, this would be ES6 components
 * and not one file with a bunch of objects
 * with the need to save the scope to use in anonymous functions
 */


/**
 * This class would in a separate service class
 */
var httpClient = new (function(baseUrl) {
    var baseUrl = baseUrl;

    this.getStations = function() {
       return axios.get(baseUrl + '/stations');
    }
    this.getTrains = function(stationCode) {
        return axios.get(baseUrl + '/trains?stationCode=' + stationCode);
    }
})('http://localhost:8080/api/wmata');


/**
 * Ideally, this would use Vuejs router
 * and be componetized.
 */
var wmataApp = new Vue({
    el: '#app',
    data: {
        message: 'hello',
        errorResponse: false,
        stationSelected: '',
        stations: [],
        trains: [],
    },

    created: function() {
        this.getStations();
    },

    methods: {
        getStations: function() {
            var stationScope = this;
            stationScope.errorResponse  = false;
            httpClient.getStations().then(function(response) {
                console.log(response);
                /**
                 * in a full app the backend would have already transformed the data into exactly
                 * what the frontend needs
                 */
                response.data.Stations.forEach(function (station) {
                    stationScope.stations.push({
                        text: station.Name,
                        value: station.Code
                    });
                })

            }).catch(function(error){
                console.log(error);
                stationScope.errorResponse = true;
                /**
                 * Error handling would be done in the backend and a service class would handle the displaying of errors in the frontend
                 *
                 */
                document.querySelector('#error-response P').innerText = 'There was a problem loading the stations!  Please refresh the page.';
            })
        },

        getTrains: function() {
            var trainScope = this;
            trainScope.errorResponse  = false;
            trainScope.trains = [];
            httpClient.getTrains(trainScope.stationSelected).then(function(response) {
                console.log(response);
                /**
                 * in a full app the backend would have already transformed the data into exactly
                 * what the frontend needs
                 */
                response.data.Trains.forEach(function (train) {
                    trainScope.trains.push({
                        location: train.LocationName,
                        destination: train.DestinationName,
                        timeInMinutes: train.Min
                    });
                })


                if(trainScope.trains.length == 0) {
                    trainScope.errorResponse = true;
                    document.querySelector('#error-response P').innerText = 'No train information available for the selected station.';

                }
            }).catch(function(error){
                console.log(error);
                trainScope.errorResponse = true;
                /**
                 * Error handling would be done in the backend and a service class would handle the displaying of errors
                 *
                 */
                document.querySelector('#error-response P').innerText = 'There was a problem loading the trains!  Please try again.';
            })
        }
    }
});