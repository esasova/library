<template>
  <div>
    <Banner />
    <div class="py-10 text-center montserrat font50 base--text">
      Formulaire d'inscription
  </div>
  <hr class="base"/>
  <v-form
    ref="inscriptionForm"
    v-model="valid"
    lazy-validation
    >
    <v-col cols=12 md=6>
      <v-text-field
      v-model="name"
      label="Prénom"
      :rules="rules"
      required
      outlined
      color="base"
      />
    </v-col>
    <v-col cols=12 md=6>
      <v-text-field
      v-model="surname"
      label="Nom de famille"
      :rules="rules"
      required
      outlined
      color="base"
      />
    </v-col>
    <v-col cols=12 md=6>
      <v-text-field
        v-model="email"
        label="Email"
        :rules="rules"
        required
        outlined
        color="base"
      />
    </v-col>
    <v-col cols=12 md=6>
      <v-text-field
        v-model="address"
        label="Adresse"
        :rules="rules"
        required
        outlined
        color="base"       
      />
    </v-col>
    <v-col cols=12 md=6>
      <v-text-field
      v-model="psw"
      label="Mot de passe"
      :rules="rules"
      required
      outlined
      color="base"
      type="password"
      />
    </v-col>
    <v-col>
      <v-btn :disabled="!valid" color="primary" @click="handleSubmit">S'inscrire</v-btn>
    </v-col>
  </v-form>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        valid: true,
        name: null,
        surname: null,
        email: null,
        address: null,
        psw: null,
        rules: [v => !!v || 'Ce champs est obligatoire']
      }
    },
    methods: {
      async handleSubmit () {
        if(this.$refs.inscriptionForm.validate()) {
          await this.$axios.$post('http://localhost:8000/api/users', 
          {
              name: this.name,
              surname: this.surname,
              email: this.email,
              address: this.address,
              password: this.psw,
              isValidated: false
          })
          .then(() => {
            this.$auth.loginWith('local', {
          data: {
            username: this.email,
            password: this.psw
          }
        })
        .finally(() => {
            this.$router.push('/')
        })
          })
          .catch((error) => {
            console.log(error)
          })
        } else {
          this.valid = false
        }
      }
    }
  }
</script>
