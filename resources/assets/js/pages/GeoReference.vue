<template>
  <div>
    <div id="map"></div> <!-- point 1 -->
    <template v-if="!!this.google && !!this.map"> <!-- point 2 -->
      <div :google="google" :map="map">
        <slot/>
      </div>
    </template>
  </div>
</template>
<script>
import GoogleMapsApiLoader from "google-maps-api-loader";

export default {
  data() {
    return {
      mapConfig: {
        center: { lat: -12.579738, lng :-41.7007272 }, // lat: -13.3945273, lng: -46.4799032
        zoom: 6,
        zoomControl: true,
        draggable: true,
        gestureHandling: 'greedy',
        scaleControl: true,
        language:"pt",
        
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
    }).then((google) => {
      this.google = google
      this.initializeMap()
    })
    
  },

  methods: {
    async initializeMap() {
      const mapContainer = this.$el.querySelector('#map');
      
      const { Map } = await this.google.maps
      
      this.map = new Map(mapContainer, this.mapConfig)
      var marker = new this.google.maps.Marker({
          position: { lat: -12.579738, lng :-41.7007272 },
          map: this.map,
          draggable:true,
          title:"Estado da Bahia Brasil"
      });
      
    }
  }
};
</script>
<style lang="stylus">
#map {
  height: 100vh;
  width: 100%;
}
</style>

