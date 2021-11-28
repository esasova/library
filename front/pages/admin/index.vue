<template>
  <div>
      <Banner />
      <div class="py-10 text-center montserrat font50 base--text">
        Espace gérant
      </div>
      <hr class="base"/>
      <v-row justify=center>
        <v-tabs centered>
          <v-tabs-slider color="base">
          </v-tabs-slider>
            <v-tab class="base--text">
              Livres
            </v-tab>
            <v-tab class="base--text">
              Lecteurs
            </v-tab>
            <v-tab v-if="showNewUsers" class="accent--text">
              Nouvelles inscriptions
            </v-tab>
        <v-tab-item>
          <v-row>
            <v-col cols=12 md=8>
              <v-text-field
                full-width
                class="mt-6 mb-4 mx-4"
                v-model="book"
                text
                prepend-icon="search"
                solo
                placeholder="Chercher un livre"
                hide-details
                clearable
            />
            </v-col>
            <v-col cols=12 md=4 class="d-flex justify-center align-center">
              <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto" @click="searchBook"><span class="secondary--text font-weight-bold montserrat">Chercher</span></v-btn>
            </v-col>
            <v-col cols=12 md=4 class="d-flex justify-center align-center">
              <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto" to="/book/add"><span class="secondary--text font-weight-bold montserrat">Ajouter</span></v-btn>
            </v-col>
          </v-row>
        </v-tab-item>
        <v-tab-item>
          <v-row>
            <v-col cols=12 md=8>
              <v-text-field
                full-width
                class="mt-6 mb-4 mx-4"
                v-model="user"
                text
                prepend-icon="search"
                solo
                placeholder="Chercher un lecteur"
                hide-details
                clearable
            />
            </v-col>
            <v-col cols=12 md=4 class="d-flex justify-center align-center">
              <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto" @click="searchUser"><span class="secondary--text font-weight-bold montserrat">Chercher</span></v-btn>
            </v-col>
          </v-row>
        </v-tab-item>
        <v-tab-item v-if="showNewUsers">
          <v-row>
            <v-col v-for="user in newUsers" :key="user.id" cols=12>
            <v-card class="mx-6 my-5 d-flex flex-column flex-sm-row">
              <v-col cols=12 md=4>
                <v-card-title class="primary--text montserrat font-weight-bold">{{ user.name}} {{ user.surname }}</v-card-title>
              </v-col>
              <v-col cols=12 md=5>
                <v-card-text>{{ user.address }}</v-card-text>
                <v-card-text>{{ user.email }}</v-card-text>
              </v-col>
              <v-col cols=12 md=3 class="d-flex flex-column justify-center align-center">
                <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto my-2" @click="validateUser(user.id)"><span class="secondary--text font-weight-bold montserrat">Valider</span></v-btn>
                <v-btn width="50%" color="accent" elevation="0" tile class="mx-auto my-2" @click="deleteUser(user.id)"><span class="secondary--text font-weight-bold montserrat">Refuser</span></v-btn>            
            </v-col>
            </v-card>
            </v-col>
          </v-row>
        </v-tab-item>
        </v-tabs>
      </v-row>
      <v-row v-if="resultBook">
        <v-card v-for="book in resultBook" :key="book.id" class="mx-6 my-5 d-flex flex-column flex-sm-row">
          <v-col sm=3>
            <v-img :src="require('~/assets/images/defaultBook.jpg')"></v-img>
          </v-col>
          <v-col sm=4>
            <v-card-title class="montserrat primary--text">{{ book.title }}</v-card-title>
            <v-card-subtitle class="base--text">Auteur : {{ book.author }}</v-card-subtitle>
            <v-card-subtitle class="base--text pt-0">Date : {{ $dayjs(book.publicationDate).format('YYYY') }}</v-card-subtitle>
            <v-card-subtitle class="base--text pt-0">Genre : {{ book.genre }}</v-card-subtitle>
            <v-card-subtitle class="base--text pt-0">Exemplaires : {{ book.stock }}</v-card-subtitle>
          </v-col>
          <v-divider vertical inset></v-divider>  
          <v-col sm=2>
              <v-btn width="50%" color="primary" elevation="0" tile :to="`/book/${book.id}`"><span class="secondary--text font-weight-bold montserrat">Détails</span></v-btn>
          </v-col>
        </v-card>
      </v-row>
      <v-row v-if="resultUser" justify=center>
        <v-col v-for="user in resultUser" :key="user.id" cols=12 md=9 class="d-flex flex-column flex-sm-row justify-space-between">
        <div class="mx-6 my-5 d-flex flex-column">
            <p class="primary--text font-weight-bold montserrat font30">{{ user.name }} {{ user.surname }}</p>
            <p class="base--text my-auto">{{ user.address }}</p>
            <p class="base--text">{{ user.email }}</p>
        </div>
          <v-btn color="primary" elevation="0" class="mx-4 my-auto" tile :to="`/admin/details/${user.id}`"><span class="secondary--text font-weight-bold montserrat">Détails</span></v-btn>
        </v-col>
      </v-row>      
  </div>
</template>
<script>
  export default {
    middleware: 'auth-admin',
    data () {
      return {
        book: null,
        user: null,
        resultBook: null,
        resultUser: null,
        newUsers: null,
        showNewUsers: false
      }
    },
    mounted () {
      this.getNewUsers()
    },
    methods: {
      async getNewUsers () {
        await this.$axios.$get('/api/users.json')
        .then((response) => {
          this.newUsers = response.filter(u => u.isValidated === false)
          this.showNewUsers = this.newUsers.length > 0 ? true : false
        })
        .catch((error) => {
          console.log(error)
        })
      },
      async searchBook () {
        this.resultUser = null
        await this.$axios.$get('/api/books.json', 
        {
          params: {
            title: this.book
          }
        })
        .then((response) => {
          this.resultBook = response
        })
        .catch((error) => {
          console.log(error)
        })
      },
      async searchUser () {
        this.resultBook = null
        await this.$axios.$get('/api/users.json?surname=' + this.user)
        .then((response) => {
          this.resultUser = response
        })
      },
      validateUser (id) {
        this.$axios.$put('/api/users/' + id,
        {
          isValidated: true
        })
        .then(() => {
          this.getNewUsers()
        })
        .catch((error) => {
          console.log(error)
        })
      },
      deleteUser (id) {
        this.$axios.$delete('/api/users/' + id)
        .then(() => {
          this.getNewUsers()
        })
        .catch((error) => {
          console.log(error)
        })
      }
    }
  }
</script>
<style lang="scss" scoped>
.theme--light::v-deep .v-divider {
  border-color: #258ea6 !important;
} 
</style>
