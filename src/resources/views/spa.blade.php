<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WMATA Train information</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <main role="main" class="container" id="app">

        <div class="row">
            <div class="col-8 offset-2">
                <h1>WMATA Train information</h1>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger" id="error-response" v-show="errorResponse">
                            <p></p>
                        </div>
                        <form>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Select a train station to get times:</label>
                                <select class="form-control"
                                        id="train-stations"
                                        v-model="stationSelected"
                                        @change="getTrains">
                                    <option disabled value="">Select a station...</option>
                                    <option v-for="station in stations"
                                            :value="station.value">@{{ station.text }}</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <li v-for="train in trains">
                                    <strong>@{{ train.location }}</strong>
                                    ------>
                                    <strong>@{{ train.destination }}</strong>
                                    |
                                    <em>@{{ train.timeInMinutes }}</em>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main><!-- /.container -->

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
    <script src="js/wmata.js"></script>
</body>
</html>
