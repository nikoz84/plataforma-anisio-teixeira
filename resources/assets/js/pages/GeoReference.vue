<template>
  <div style="width:100%;min-heigth:60vh;background-color:#000;">
    <div id="map"></div>
  </div>
</template>
<script>
import GoogleMapsApiLoader from "google-maps-api-loader";

export default {
  data() {
    return {
      mapConfig: {
        center: { lat: -34.397, lng: 150.644 },
        zoom: 8
      },
      apiKey: "AIzaSyBxCs_ngbimWt-6ITucgoNTNJfuKUaWvvQ",
      google: null,
      map: null
    };
  },

  async mounted() {
    const googleMapApi = await GoogleMapsApiLoader({
      apiKey: this.apiKey,
      libraries: ["places"]
    });

    this.google = googleMapApi;
    this.initializeMap();
  },

  methods: {
    async initializeMap() {
      const mapContainer = await document.getElementById("map");
      console.log(mapContainer);
      this.map = new this.google.maps.Map(mapContainer, this.mapConfig);

      console.log(this.map);
    }
  }
};
</script>
