<template>
  <v-app>
    <v-app-bar v-if="$auth.user" app flat color="white" class="d-flex justify-center">
      <nuxt-link to="/" class="base--text mx-4 py-4 text-decoration-none montserrat font-weight-black font30"><v-icon v-if="$vuetify.breakpoint.smAndDown" color="base">mdi-magnify</v-icon><span v-else>Recherche</span></nuxt-link>
      <nuxt-link v-if="isAdmin" to="/admin" class="base--text mx-4 py-4 text-decoration-none montserrat font-weight-black font30"><v-icon v-if="$vuetify.breakpoint.smAndDown" color="base">mdi-account-lock</v-icon><span v-else>Espace gérant</span></nuxt-link>
      <nuxt-link v-else to="/user" class="base--text mx-4 py-4 text-decoration-none montserrat font-weight-black font30"><v-icon v-if="$vuetify.breakpoint.smAndDown" color="base">mdi-account</v-icon><span v-else>Espace adhérent</span></nuxt-link>
      <v-btn color="primary" elevation="0" tile class="mx-4" @click="logout"><v-icon v-if="$vuetify.breakpoint.smAndDown" color="secondary">mdi-exit-to-app</v-icon><span v-else class="secondary--text font-weight-bold montserrat">Log out</span></v-btn>
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
  computed: {
    isAdmin () {
  return this.$auth.user ? this.$auth.user.roles.includes('ROLE_ADMIN') : false
    }
  },
  methods: {
    async logout() {
      await this.$auth.logout()
      .then(() => {
      this.$router.push('/login')
  })
}
  }
}
</script>
