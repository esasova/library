<template>
<v-row v-if="book" justify-center>
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
    </v-col>
</v-row>
</template>
<script>
  export default {
    data () {
      return {
        book: null
      }
    },
    mounted () {
      this.getBook()
    },
    methods: {
      async getBook () {
        this.book = await this.$axios.$get('http://localhost:8000/api/books/' + this.$route.params.id + '.json')
      }
    }
  }
</script>

