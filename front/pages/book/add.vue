<template>
  <v-row class="d-flex flex-column">
    <v-form ref="addBook">
    <v-col class="d-flex flex-column flex-md-row">
      <v-text-field
      v-model="author"
      outlined
      color="base"
      label="Auteur"
      class="mx-2"
      :rules="rules"
      />
      <v-text-field
      v-model="title"
      outlined
      color="base"
      label="Titre"
      class="mx-2"
      :rules="rules"
      />
    </v-col>
    <v-col class="d-flex flex-column flex-md-row">
       <v-text-field
      v-model="publicationDate"
      outlined
      color="base"
      label="Année"
      class="mx-2"
      :rules="rules"
      />
      <v-text-field
      v-model="isbn"
      outlined
      color="base"
      label="ISBN"
      class="mx-2"
      :rules="rules"

      />
    </v-col>
    <v-col class="d-flex flex-column flex-md-row">
      <v-select
      v-model="genre"
      outlined
      color=base
      label="Genre"
      :items="availableGenre"
      item-text="text"
      item-value="value"
      class="mx-2"
      :rules="rules"
      />
       <v-text-field
      v-model.number="stock"
      outlined
      color="base"
      label="Stock"
      class="mx-2"
      :rules="rules"
      />
    </v-col>
    <v-col>
      <v-textarea
      v-model="description"
      outlined
      color="base"
      label="Description"
      class="mx-2"
      />
    </v-col>
    <v-col class="d-flex justify-center">
       <v-btn width="50%" color="primary" elevation="0" tile class="mx-auto" @click="addBook"><span class="secondary--text font-weight-bold montserrat">Ajouter</span></v-btn>
    </v-col>
    </v-form>
    <v-alert v-if="added" color="primary" text="secondary">Le livre a bien été ajouté</v-alert>
  </v-row>
</template>
<script>
export default {
  middleware: 'auth-admin',
  data () {
    return {
      author: null,
      title: null,
      stock: 0,
      description: '',
      isbn: null,
      publicationDate: null,
      genre: null,
      availableGenre: [
        {text: 'Roman', value: 'roman'},
        {text: 'BD', value: 'BD'},
        {text: 'Documentaire', value: 'documentaire'},
        {text: 'Poésie', value: 'poésie'},
        {text: 'Policier', value: 'policier'},
        {text: 'Manga', value: 'manga'}
      ],
      added: false,
      rules: [v => !!v || 'Ce champs est obligatoire']
    }
  },
  methods: {
    async addBook () {
      if(this.$refs.addBook.validate()) {
        await this.$axios.$post('http://localhost:8000/api/books',
      {
        author: this.author,
        title: this.title,
        publicationDate: this.$dayjs(this.publicationDate).format(),
        ISBN: this.isbn,
        description: this.description,
        genre: this.genre,
        stock: this.stock
      })
      .then(() => {
        this.$refs.addBook.reset()
        this.added = true
      })
      }
    }
  }
}
</script>
