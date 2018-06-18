<?php require "actions.php";
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Торбо - агро</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
        <script src="main.js"></script>
    -->
    <link rel="stylesheet" type="text/css" media="screen" href="main.css?123" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>
</head>
<body>

    <div id="torbo-app" >

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Маршрутизатотрон</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a @click="addRoute()" href="#" class="nav-link">Еще маршрут <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </nav>

        <routecalc v-for="route in routes" :data="route" ></routecalc>

        <div>
        <table class="table">
            <tbody>
                <tr v-for="route in routesLog" >
                    <td>{{route.date}}</td>
                    <td>{{route.info}}</td>
                    <td>{{route.dist}}</td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>

<?php require "dataservice.php";?>
<?php require "ctl_addr.php";?>
<?php require "cmp_calcroute.php";?>

<script>
new Vue({
    el: '#torbo-app',
    mixins: [dataService],
    components: {
        routecalc: cmpRouteCalc
    },
});
</script>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </body>
</html>