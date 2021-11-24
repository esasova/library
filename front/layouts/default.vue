<template>
  <v-app>
    <v-app-bar app flat color="white" class="d-flex justify-center">
      <nuxt-link to="/" class="base--text mx-4 py-4 text-decoration-none montserrat font-weight-black" :class="$vuetify.breakpoint.smAndUp ? 'font30' : ''">Recherche</nuxt-link>
      <nuxt-link to="/" class="base--text mx-4 py-4 text-decoration-none montserrat font-weight-black" :class="$vuetify.breakpoint.smAndUp ? 'font30' : ''">Espace adhérent</nuxt-link>
    </v-app-bar>
    <v-main>
      <v-container class="customContainer">
        <Nuxt />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {  
}
</script>
