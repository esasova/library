<template>
<div v-if="user">
  <Banner />
      <div class="pt-10 text-center montserrat font50 base--text">
        {{ user.name }} {{ user.surname }}
      </div>
      <div class="base--text my-auto pb-10 text-center">{{ user.address }} <br/> {{ user.email }}</div>
  <hr class="base my-5"/> 
  <div class="primary--text font-weight-bold montserrat text-center font30 my-6">Emprunts</div>
<div class="d-flex flex-column">
<v-card v-for="loan in user.borroweds" :key="loan.id" class="my-3 mx-6 pa-3 d-flex flex-column flex-sm-row justify-space-between align-center">
  <div>
  <div class="primary--text montserrat">{{ loan.Book.title }}</div>
  <div class="base--text">{{ loan.Book.author }}</div>
  <div class="base--text">{{ $dayjs(loan.Book.publicationYear).format('YYYY') }}</div>
  <div v-if="$dayjs($dayjs(loan.end).format()).isBefore($dayjs().format())" class="accent--text font-weight-black">
    Ce livre est en retard ! La date de retour est {{ $dayjs(loan.end).format('DD-MM-YYYY') }}
    </div>
  <div v-else class="base--text">{{ $dayjs(loan.end).format('DD-MM-YY') }}</div>
  </div>
  <div>
    <v-btn color="primary" elevation="0" tile class="mx-4 pa-2" @click="returnBook(loan.id, loan.Book.id, loan.Book.stock)"><span class="secondary--text font-weight-bold montserrat">Restituer</span></v-btn>
  </div>
</v-card>
</div>
<v-divider inset class=my-4></v-divider>  
<div class="primary--text font-weight-bold montserrat text-center font30 my-6">Réservations</div>
<div class="d-flex flex-column">
<v-card v-for="res in user.reserveds" :key="res.id" class="my-3 mx-6 pa-3 d-flex flex-column flex-sm-row justify-space-between align-center">
  <div>
  <div class="primary--text montserrat">{{ res.Book.title }}</div>
  <div class="base--text">{{ res.Book.author }}</div>
  <div class="base--text">{{ $dayjs(res.Book.publicationYear).format('YYYY') }}</div>
  <div class="base--text">{{ $dayjs(res.end).format('DD-MM-YY') }}</div>
  </div>
  <div>
    <v-btn color="primary" elevation="0" tile class="mx-4 pa-2" @click="validateReservation(res.Book.id, res.id)"><span class="secondary--text font-weight-bold montserrat">Valider</span></v-btn>
    <v-btn color="accent" elevation="0" tile class="mx-4 pa-2" @click="refuseReservation(res.Book.id, res.id, res.Book.stock)"><span class="secondary--text font-weight-bold montserrat">Refuser</span></v-btn>
  </div>
</v-card>
</div>
</div>
</template>
<script>
  export default {
    middleware: 'auth-admin',
    data () {
      return {
        user: null
      }
    },
    mounted () {
      this.searchUserbyId()
    },
    methods: {
      async searchUserbyId () {
        await this.$axios.$get('/api/users/' + this.$route.params.id + '.json')
        .then((response) => {
          this.user = response
        })
      },
      async validateReservation (bookId, resId) {
        await this.$axios.$post('/api/borroweds', {
          start: this.$dayjs().format(),
          end: this.$dayjs().add(3, 'week').format(),
          user: '/api/users/' + this.user.id,
          book: '/api/books/' + bookId
        })
        .then(() => {
          this.$axios.$delete('/api/reserveds/' + resId)
        })
        .finally(() => {
          this.searchUserbyId()
        })
      },
      async refuseReservation (bookId, resId, stock) {
        await this.$axios.$delete('/api/reserveds/' + resId)
        .then(() => {
          this.$axios.$put('/api/books/' + bookId,
          {
            stock: stock + 1
          })
        })
        .finally(() => {
          this.searchUserbyId()
        })
      },
      async returnBook (loanId, bookId, stock) {
        await this.$axios.$delete('/api/borroweds/' + loanId)
        .then(() => {
          this.$axios.$put('/api/books/' + bookId,
          {
            stock: stock + 1
          })
        })
        .finally(() => {
          this.searchUserbyId()
        })
    }
    }
  }
</script>
