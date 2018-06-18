<script>
var __6734cwynwcy47nyctnoweyrtwuerthy78 = [];
var dataService = {
    data: function() {
        return {
            routes: [],
            routesLog: __6734cwynwcy47nyctnoweyrtwuerthy78,
            googleMapsKye: 'AIzaSyBu6ShisHv8uABtNotv6BiQAJqcwHYIAc8',
            failResult: { data: { status: 'FAIL' } }
        }
    },
    created: function() {
        this.addRoute();
    },
    methods: {
        addToLog: function(record) {
            that.routesLog.unshift(record);
        },
        addRoute: function() {
            if(this.routes.length > 9) return;
            this.routes.unshift({ fr: null, to: null, dist: null });
        },
        routing: function(places, fn) {
            var that = this;
            if(!places[0] || !places[1]) {
                fn(this.failResult);
                this.addToLog({ date: that.strDate(), info: 'Не задан маршрут' });
                return;
            }

            var data = [];
            for(var index in places) {
                data.push(places[index].place_id);
            }

            this.$http.post('/?action=routing', { places: data }, { emulateJSON: true }).then(function(response) {
                fn(response.body);
            }, function() {
                fn(that.failResult);
            });
        },
        geocoding: function(addr, fn) {
            var that = this;
            this.$http.post('/?action=geocoding', { address: addr }, { emulateJSON: true }).then(function(response) {
                fn(response.body);
            }, function(){
                fn(that.failResult);
            });

        },
        strDate: function() {
            var now = new Date();
            var dd = now.getDate();
            var mm = now.getMonth() + 1;

            var HH = now.getHours();
            var MM = now.getMinutes();

            if(dd < 10) dd = '0' + dd;
            if(mm < 10) mm = '0' + mm;
            
            if(HH < 10) HH = '0' + HH;
            if(MM < 10) MM = '0' + MM;

            return dd + '/' + mm + ' в ' + HH + ':' + MM;
        },
    }
};
</script>