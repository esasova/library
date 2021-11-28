<template>
    <div>
      <Banner/>
      <div class="py-10 text-center montserrat font50 base--text">
        Recherche dans le catalogue
      </div>
      <hr class="base"/>
      <v-row justify=center class="mt-6">
        <div class="montserrat base--text font-weight-bold">
          Bonjour {{ loggedInUser.name }}
          </div>
      </v-row>
      <v-row justify=center>
        <v-tabs centered>
          <v-tabs-slider color="base">
          </v-tabs-slider>
            <v-tab class="base--text">
              Simple
            </v-tab>
            <v-tab class="base--text">
              Avancée
            </v-tab>
        <v-tab-item>
          <v-row>
            <v-col cols=12 md=8>
              <v-text-field
                full-width
                class="mt-6 mb-4 mx-4"
                v-model="simpleSearch"
                text
                prepend-icon="search"
                solo
                placeholder="Chercher votre livre"
                hide-details
                clearable
            />
            </v-col>
            <v-col cols=12 md=4 class="d-flex justify-center align-center">
              <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto" @click="simpleSearchBooks"><span class="secondary--text font-weight-bold montserrat">Chercher</span></v-btn>
            </v-col>
          </v-row>
        </v-tab-item>
        <v-tab-item>
          <v-row>
            <v-col cols=12 md=8 class="d-flex flex-column flex-md-row">
              <div class="d-flex flex-column flex-md-row ml-md-4" style="width: 100%">
                <v-text-field
                  full-width
                  class="mt-6 mb-4 mx-4"
                  v-model="author"
                  text
                  solo
                  label="Auteur"
                  hide-details
                  clearable
              />
                <v-select
                  class="mt-6 mb-4 mx-4"
                  v-model="genre"
                  :items="availableGenre"
                  item-text=""
                  label="Genre"
                  solo
                />
                <v-text-field
                  full-width
                  class="mt-6 mb-4 mx-4"
                  v-model="yearFrom"
                  text
                  solo
                  label="De"
                  hide-details
                  clearable
              />
                <v-text-field
                  full-width
                  class="mt-6 mb-4 mx-4"
                  v-model="yearTo"
                  text
                  solo
                  label="à"
                  hide-details
                  clearable
              />
              </div>
            </v-col>
            <v-col cols=12 md=4 class="d-flex justify-center align-center">
              <v-btn :width="$vuetify.breakpoint.mdAndUp ? '80%' : '50%'" color="primary" elevation="0" tile class="mx-auto" @click="advancedSearch"><span class="secondary--text font-weight-bold montserrat">Chercher</span></v-btn>
            </v-col>
          </v-row>
        </v-tab-item>
        </v-tabs>
      </v-row>
      <v-row v-if="result">
        <v-card v-for="book in result" :key="book.id" class="mx-6 my-5 d-flex flex-column flex-sm-row">
          <v-col sm=3>
            <v-img :src="require('~/assets/images/defaultBook.jpg')"></v-img>
          </v-col>
          <v-col sm=6>
            <v-card-title class="montserrat primary--text">{{ book.title }}</v-card-title>
            <v-card-subtitle class="base--text">Auteur : {{ book.author }}</v-card-subtitle>
            <v-card-subtitle class="base--text pt-0">Date : {{ $dayjs(book.publicationDate).format('YYYY') }}</v-card-subtitle>
          </v-col>
          <v-col sm=3>
              <v-btn width="50%" color="primary" elevation="0" tile :to="`/book/${book.id}`"><span class="secondary--text font-weight-bold montserrat">Détails</span></v-btn>
          </v-col>
        </v-card>
      </v-row>
    </div>
</template>
<script>
import qs from 'qs'
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth-admin-or-reader',
  data () {
    return {
      simpleSearch: null,
      author: null,
      yearFrom: null,
      yearTo: null,
      genre: null,
      result: null,
      availableGenre: ['roman', 'BD', 'poésie', 'documentaire', 'policier', 'manga']
    }
  },
    computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser'])
  },
  methods: {
    async simpleSearchBooks () {
     await this.$axios.$get('/api/books.json?title=' + this.simpleSearch)
      .then((response) => {
        this.result = response
      })
      .catch((error) => {
        console.log(error)
      })
    },
    async advancedSearch () {
      await this.$axios.$get('/api/books.json',
      {
        params: {
          author: this.author,
          genre: this.genre,
          publicationDate: {
            after: this.$dayjs(this.yearFrom).startOf('year').format('YYYY-MM-DD HH:mm:ss'),
            before: this.$dayjs(this.yearTo).endOf('year').format('YYYY-MM-DD HH:mm:ss')
          }
        },
        paramsSerializer: qs.stringify
      }
      )
      .then((response) => {
        this.result = response
      })
      .catch((error) => {
        console.log(error)
      })
    }
  }
}
</script>
