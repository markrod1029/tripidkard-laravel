<template>
    <div class="container">
      <div class="mapouter">
        <div class="gmap_canvas">
          <iframe 
            width="100%" 
            height="400" 
            id="gmap_canvas"
            :src="googleMapUrl"
            frameborder="0" 
            scrolling="no" 
            marginheight="0" 
            marginwidth="0"
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      merchant: {
        type: Object,
        required: true
      }
    },
    computed: {
      googleMapUrl() {
        const { street, city, province, zip } = this.merchant;
        const address = `${zip}, ${street}, ${city}, ${province}`;
        console.log(address);
        const encodedAddress = encodeURIComponent(address);
        return `https://maps.google.com/maps?q=${encodedAddress}&t=&z=15&ie=UTF8&iwloc=&output=embed`;
      }
    }
  };
  </script>
  
  <style scoped>
  .container {
    width: 100%;
    height: 100%;
  }
  
  .mapouter {
    position: relative;
    text-align: right;
    height: 400px;
    width: 100%;
  }
  
  .gmap_canvas {
    overflow: hidden;
    background: none !important;
    height: 400px;
    width: 100%;
  }
  </style>
  