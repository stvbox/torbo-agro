<script type="text/x-template" id="geo-place-input">
    <div class="geo-input-holder form-control" >
        <!--
        <div>{{debug}}</div>
        <div>{{loader}}</div>
        -->
        <div class="input-border" >
            <div :style="adressStyle" class="input-address" >
                <span>{{ currentAddress }}</span>
            </div>
            <div :style="placesStyle" class="input-places shadow-sm p-1 mb-5 bg-white rounded" :class="{loader: loader}" >
                <div v-for="item of variants" :key="item.place_id" @mousedown="selectAddress(item)" >
                        <!-- {{ item.formatted_address }} -->
                        {{ item.formatted_address }}
                </div>
            </div>
            <input
                v-model="searchPhrase"
                @focus="onFocus()"
                @blur.self="onBlur()"
                @keyup="searchPlace($event.target.value)"
                :style="inputStyle"
            />
        </div>
    </div>
</script>

<script>
var cmpGeoPlaceInput = {
    template: '#geo-place-input',
    mixins: [dataService],
    props: ['value'],
    data: function() {
        return {
            debug: null,
            editMode: false,
            searchPhrase: '',
            variants: [],
            inputTimer: null,
            loader: false
        };
    },
    computed: {
        currentAddress: function() {
            if(this.value && this.value.formatted_address) {
                return this.value['formatted_address'];
            }
            return '(пункт не выбран)';
        },
        inputStyle: function() {
            var oStyle = {};
            if(this.editMode) {
                oStyle = {
                };
            }
            else {
                oStyle = {
                    'color': 'transparent',
                    'background-color': 'transparent'
                };
            }
            return oStyle;
        },
        adressStyle: function() {
            return {
                display: this.editMode?'none':'block'
            }
        },
        placesStyle: function() {

            //console.log('this.variants.length: ' + this.variants.length);

            return {
                //display: (this.editMode && this.variants.length)?'block':'none',
                display: (this.editMode)?'block':'none',
            }
        }
    },
    methods: {
        searchPlace: function(address) {
            var that = this;
            this.loader = true;
            
            console.log('запрос: ' + address);
            clearTimeout(this.inputTimer);

            this.inputTimer = setTimeout(function() {
                var timer = that.inputTimer;

                that.geocoding(address, function(response) {
                    if(timer != that.inputTimer) return;
                    that.loader = false;

                    console.log('ответ: ' + address);
                    console.log(JSON.stringify(response.data.results));
                    if(response.data.results)
                        that.variants = response.data.results;
                    else
                        that.variants = [];
                });
            }, 1000);

        },
        selectAddress: function(item) {
            this.value = item;
            this.$emit('input', this.value);
            this.searchPhrase = '';
        },
        onFocus: function() {
            console.log('onFocus');
            this.editMode = true;
        },
        onBlur: function() {
            console.log('onBlur');
            this.editMode = false;
        }
    }
};
</script>