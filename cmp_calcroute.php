<script type="text/x-template" id="route-counter">
    <div class="row">
        <div class="col-md">
            <geoplaceinput v-model="fr" ></geoplaceinput>
        </div>
        <div class="col-md">
            <geoplaceinput v-model="to" ></geoplaceinput>
        </div>
        <div class="col-md">
            <div class="btn-group d-flex justify-content-center bd-highlight" role="group" aria-label="Кнопки">
                <button @click="calcDistance()" type="button" class="btn btn-primary" :class="{loader: busy}" >рассчитать</button>
                <button @click="reset()" type="button" class="btn btn-secondary">очистить</button>
            </div>
        </div>
    </div>
</script>

<script>
var cmpRouteCalc = {
    template: '#route-counter',
    mixins: [dataService],
    components: {
        geoplaceinput: cmpGeoPlaceInput
    },
    data: function() {
        return {
            fr: null,
            to: null,
            debug: null,
            busy: false
        };
    },
    methods: {
        fieldsToObject: function(fields) {
            var res = {};
            for(var index in fields) Object.assign(res, fields[index]);
            return res;
        },
        reset: function() {
            this.fr = null;
            this.to = null;
        },
        calcDistance: function() {
            if(this.busy) return;

            that = this;
            this.busy = true;

            this.routing([this.fr, this.to], function(resp) {
                that.busy = false;
                that.debug = resp;

                if(resp.data.status == 'FAIL') {
                    that.addToLog({
                        date: that.strDate(),
                        info: 'Сервис не доступен',
                    });
                }

                for(var irow in resp.data.rows) {
                    var row = resp.data.rows[irow];

                    var resRow = that.fieldsToObject(row.elements);
                    
                    if(resRow['status'] == 'ZERO_RESULTS') {
                        that.addToLog({
                            date: that.strDate(),
                            info: 'Маршрут не найден',
                        });    
                    }

                    if(resRow['status'] == 'OK') {
                        var dist = resRow.distance.text;
                        that.addToLog({
                            date: that.strDate(),
                            info: resp.data['destination_addresses'] + ' > ' + resp.data['origin_addresses'],
                            dist: dist
                        });
                    }

                    that.debug = resRow;
                }

            });
        }
    }
};
</script>