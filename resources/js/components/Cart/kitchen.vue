<template>
    <div>
        <v-layout align-center justify-center>
        <v-flex xs11>
          <v-layout column>
            <v-card>
              <v-layout column>
                <GmapMap
                    :center="center"
                    :zoom="4"
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
        <p>Selected Position: {{ marker.position }}</p>
    </div>

</template>
<script>
export default {
    data() {
    return {
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
    //detects location from browser
    geolocate() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.marker.position = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };

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
      console.log(e);
    },
  },

}
</script>
