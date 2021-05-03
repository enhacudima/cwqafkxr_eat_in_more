<template>
    <div>
        <v-form ref="kitchenForm" v-model="valid" lazy-validation>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="kitchenData.aliase"
                        label="Aliase"
                        prepend-icon="mdi-pencil-outline"
                        required
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-autocomplete
                    prepend-icon="mdi-stove"
                    v-model="kitchenData.type_stove_power_source"
                    :items="type_stove_power_source"
                    label="Stove Power Source"
                    required
                    :rules="[rules.required]"
                    dense
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                    <v-autocomplete
                    prepend-icon="mdi-stove"
                    v-model="kitchenData.stove_backup"
                    :items="type_stove_power_source"
                    label="Stove Backup"
                    required
                    :rules="[rules.required]"
                    dense
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="6">
                    <p>Grill Available</p>
                    <v-radio-group
                    v-model="kitchenData.grill_available"
                    required
                    :rules="[rules.required]"
                    row
                    >
                    <v-radio
                        label="Yes"
                        value="yes"
                    ></v-radio>
                    <v-radio
                        label="No"
                        value="no"
                    ></v-radio>
                    </v-radio-group>
                </v-col>
                <v-col cols="6">
                    <p>Oven Available</p>
                    <v-radio-group
                    v-model="kitchenData.oven_available"
                    required
                    :rules="[rules.required]"
                    row
                    >
                    <v-radio
                        label="Yes"
                        value="yes"
                    ></v-radio>
                    <v-radio
                        label="No"
                        value="no"
                    ></v-radio>
                    </v-radio-group>
                </v-col>

                <v-col cols="12">
                    <v-text-field
                        v-model="kitchenData.full_address"
                        label="Full address"
                        prepend-icon="mdi-map-marker-outline"
                        required
                        :rules="[rules.required]"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-layout align-center justify-center>
                    <v-flex xs11>
                    <v-layout column>
                        <v-card>
                        <v-layout column>
                            <GmapMap
                                :center="center"
                                :zoom="6"
                                map-style-id="roadmap"
                                :options="mapOptions"
                                style="width: 100%; height: 40vmin"
                                ref="mapRef"
                                @click="handleMapClick"
                            >
                                <GmapMarker
                                :position="marker.position"
                                :clickable="true"
                                :draggable="true"
                                @drag="handleMarkerDrag"
                                @click="panToMarker"
                                />
                            </GmapMap>

                        </v-layout>
                        </v-card>
                    </v-layout>
                    </v-flex>
                    </v-layout>

                    <v-btn
                    text
                    color="primary"
                    @click="geolocate"
                    >
                    <v-icon left>
                        mdi-crosshairs-gps
                    </v-icon>
                    Detect My Location
                    </v-btn>
                    <!--<p>Selected Position: {{ marker.position }}</p>-->

                </v-col>
            </v-row>

            <v-spacer></v-spacer>
            <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                <v-btn elevation="1" block  :disabled="!valid" color="primary" @click="validate">Save</v-btn>
            </v-col>
        </v-form>

    </div>

</template>
<script>
export default {

    props: ['existeKitchen'],
    created () {
        //console.log(this.userID)
    },
    data() {
    return {
        userID: JSON.parse(localStorage.getItem('user')).logged_in_user.id ,
        rules: {
            required: value => !!value || "Required.",
        },
        valid:true,
        type_stove_power_source:[
            "Gas",
            "Electric coil cooktop",
            "Electric smooth top cooktop",
            "Induction cooktop",
            "Downdraft cooktop",
            "Pellet stoves",
            "Modular cooktops",
            "Other"

        ],
        kitchenData:{
            aliase:null,
            full_address:null,
            type_stove_power_source:null,
            stove_backup:null,
            grill_available:null,
            lat:null,
            lng:null,
            oven_available:null,
        },

        marker: { position: { lat: 10, lng: 10 } },
        center: { lat: -27.709170290864915, lng: 30.871627324999988 },

        mapOptions: {
            disableDefaultUI: true,
            streetViewControl: false,
            mapTypeControl: true,
            zoomControl: true,
            fullscreenControl: true,
        },
    };
  },
    mounted() {
    this.geolocate();
  },
  methods: {

    validate() {
      if (this.$refs.kitchenForm.validate()) {

        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.kitchenData);
      }
    },
    sendData(data) {
      axios
      .post("createKitchen", { data: { kitchenData: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              this.existeKitchenCom=false;
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

          } else {
              this.existeKitchenCom=true;
              this.openNotification('success', 'Save', 'You have been store all data successfully');

          }
      })
      .catch((error) => {
        this.success = false;
        var errors =null;
        var status=error.response.status;
        //console.log(status);
            if (status == 422){
            errors=error.response.data.errors;
            //console.log(errors);
            errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
          }else{
            this.openNotification('error','Error on Save',error);
          }
      });
    },

  openNotification: function (type, m, d) {
      this.$notification.config({
          placement: 'topRight',
          top: 35,
          duration: 8,
      });
      this.$notification[type]({
        message: m,
        description: d,
      });
  },

    //detects location from browser
    geolocate() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.marker.position = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.kitchenData.lat=position.coords.latitude,
        this.kitchenData.lng=position.coords.longitude,

        this.panToMarker();
      });
    },

    //sets the position of marker when dragged
    handleMarkerDrag(e) {
      this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
    },

    //Moves the map view port to marker
    panToMarker() {
      this.$refs.mapRef.panTo(this.marker.position);
    },

    //Moves the marker to click position on the map
    handleMapClick(e) {
      this.marker.position = { lat: e.latLng.lat(), lng: e.latLng.lng() };
      //console.log(e);
    },
  },
    computed: {
        existeKitchenCom: {
        get () {
            return this.existeKitchen
        },
        set (value) {
            this.$emit('update:existeKitchen', value)
        }
        },
    },
    watch:{
        existeKitchen:{
            handler(val){
               // console.log('watch', val);
            },

            deep: true,
            immediate: true

        }
    },

}
</script>
