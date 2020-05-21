<template>
  <div class="q-pa-sm">
    <Title title="Práticas Pedagógicas"></Title>
    <div id="map"></div>
    <template v-if="!!this.google && !!this.map">
      <div :google="google" :map="map">
        <slot />
      </div>
    </template>
  </div>
</template>
<script>
import GoogleMapsApiLoader from "google-maps-api-loader";
import { Title } from "@components/shared";

export default {
  name: "PraticasPedagogicas",
  components: { Title },
  data() {
    return {
      mapConfig: {
        center: { lat: -12.579738, lng: -41.7007272 },
        zoom: 6,
        zoomControl: true,
        draggable: true,
        gestureHandling: "greedy",
        scaleControl: true,
        language: "pt"
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
    }).then(google => {
      this.google = google;
      this.initializeMap();
    });
  },

  methods: {
    async initializeMap() {
      const mapContainer = this.$el.querySelector("#map");

      const { Map } = await this.google.maps;

      this.map = new Map(mapContainer, this.mapConfig);
      let marker = new this.google.maps.Marker({
        position: { lat: -12.579738, lng: -41.7007272 },
        map: this.map,
        draggable: true,
        title: "Estado da Bahia Brasil"
      });

      let request = {
        query: "Bahia, Brasil",
        fields: ["name", "geometry"]
      };
      let service = new this.google.maps.places.PlacesService(this.map);

      service.findPlaceFromQuery(request, (results, status) => {
        console.log(results);
      });
    }
  }
};
</script>
<style lang="stylus">
#map {
  width: 100%;
  height: 75vh;

}
</style>
