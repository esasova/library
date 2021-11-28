<template>
<v-row v-if="book && user" justify-center>
    <v-col cols=12 sm=8 class="mx-auto">
        <v-card class="mx-6 my-5 d-flex flex-column flex-sm-row justify-center align-center">
          <v-col sm=3>
            <v-img :src="require('~/assets/images/defaultBook.jpg')"></v-img>
          </v-col>
          <v-col sm=5>
            <v-card-title class="montserrat primary--text">{{ book.title }}</v-card-title>
            <v-card-subtitle class="base--text">Auteur : {{ book.author }}</v-card-subtitle>
            <v-card-subtitle class="base--text pt-0">Date : {{ $dayjs(book.publicationDate).format('YYYY') }}</v-card-subtitle>
            <v-card-subtitle>{{ book.genre }}</v-card-subtitle>
          </v-col>
          <v-col sm=4>
            <v-card-text>{{ book.description }}</v-card-text>
          </v-col>
        </v-card>
        <v-btn color="primary" elevation="0" tile class="mx-6 mt-4" @click="reserveBook" :disabled="reserved || book.stock < 0 || !user.isValidated"><span class="secondary--text font-weight-bold montserrat">Réserver</span></v-btn>
        <v-col v-if="!user.isValidated" class="accent--text montserrat mt-2 mx-6">
          Pour réserver un livre, votre inscription doit être validée. Adressez-vous à nos employés
        </v-col>
    <v-col v-if="reserved" class="montserrat primary--text">Le livre a été réservé</v-col>
    </v-col>
</v-row>
</template>
<script>
  export default {
    data () {
      return {
        book: null,
        reserved: false,
        user: null
      }
    },
    mounted () {
      this.getBook(),
      this.searchUserbyId()
    },
    methods: {
      async getBook () {
        this.book = await this.$axios.$get('/api/books/' + this.$route.params.id + '.json')
      },
      async searchUserbyId () {
        await this.$axios.$get('/api/users/' + this.$auth.user.id + '.json')
        .then((response) => {
          this.user = response
        })
      },
      async reserveBook () {
        await this.$axios.$post('/api/reserveds', {
          start: this.$dayjs().format(),
          end: this.$dayjs().add(3, 'day').format(),
          user: '/api/users/' + this.$auth.user.id,
          book: '/api/books/' + this.book.id
        })
        .then(() => {
          this.reserved = true
          this.$axios.$put('/api/books/' + this.book.id,
          {
            stock: this.book.stock - 1
          })
        })
      }
    }
  }
</script>

