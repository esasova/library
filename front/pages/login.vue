<template>
  <div>
    <Banner />
      <div class="py-10 text-center montserrat font50 base--text">
        Connectez-vous
      </div>
      <hr class="base"/>
    <v-row class="d-flex flex-column flex-md-row justify-center align-center mt-6">
      <v-col>
        <v-text-field
        class="mx-6"
        v-model="email"
        label="Votre email"
        outlined
        color="base"
        />
      </v-col>
      <v-col>
        <v-text-field
        class="mx-6"
        v-model="psw"
        label="Votre mot de passe"
        outlined
        color="base"
        type="password"
        />
      </v-col>
      <v-col class="d-flex justify-center align-center">
          <v-btn color="primary" elevation="0" tile class="mx-4" @click="login"><span class="secondary--text font-weight-bold montserrat">Se connecter</span></v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col v-if="invalidCred" class="text-center accent--text font-weight-bold montserrat col-12">Mauvais identifiants</v-col>
      <v-col v-if="unexpectedError" class="text-center accent--text font-weight-bold montserrat col-12">Erreur innatendue, adressez-vous à nos employés</v-col>
    </v-row>
    <v-row>
      <v-col class="text-center montserrat base--text">
        Nouveau utilisateur ? <nuxt-link class="primary--text font-weight-bold" to="/inscription"> Enregistrez-vous </nuxt-link> pour accéder au catalogue
      </v-col>
    </v-row>
  </div>
</template>
<script>
  export default {
    data () {
      return {
        email: '',
        psw: '',
        invalidCred: false,
        unexpectedError: false
      }
    },
    methods: {
      async login () {
      try {
        await this.$auth.loginWith('local', {
          data: {
            username: this.email,
            password: this.psw
          }
        })
        .then((resp) => {
          console.log('toto')
          if(this.$auth.user.roles.includes('ROLE_ADMIN')) {
            this.$router.push('/admin')
          } else {
            this.$router.push('/')
          }
        })
      } catch (error) {
        if(error.response.status === 401) {
          this.invalidCred = true
        } else {
          this.unexpectedError = true
        }
      }
    }
    }
  }
</script>
