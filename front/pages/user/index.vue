<template>
  <div>
    <Banner />
    <div class="py-10 text-center montserrat font50 base--text">
      Espace personnel de {{ loggedInUser.surname }} {{ loggedInUser.name }}

  </div>
  <hr class="base"/>
  <v-row v-if="user" class="d-flex justify-center my-6">
      <v-card class="mx-6 mt-4 col-md-5">
        <v-card-title class="montserrat primary--text font-weight-bold font30">
          Vos emprunts
        </v-card-title>
       <v-col v-if="user.borroweds.length === 0" class="base--text montserrat text-center">
         Vous n'avez pas d'emprunts
        </v-col> 
      <v-col v-for="(loan, i) in user.borroweds" :key="loan.id">
      <v-card-text class="montserrat primary--text font20">
        {{ loan.Book.title }}
      </v-card-text>
      <v-card-text class="base--text py-0">
        {{ loan.Book.author }} ({{ $dayjs(loan.Book.publicationDate).format('YYYY') }})
      </v-card-text>
      <v-card-text v-if="$dayjs($dayjs(loan.end).format()).isBefore($dayjs().format())" class="accent--text font-weight-black">
        Ce livre est en retard ! La date de retour est {{ $dayjs(loan.end).format('DD-MM-YYYY') }}
      </v-card-text>
      <v-card-text v-else class="base--text">
        La date de retour : {{ $dayjs(loan.end).format('DD-MM-YYYY') }}
      </v-card-text>
      <hr class="base" :class="i + 1 === user.borroweds.length ? 'd-none' : ''"/>
      </v-col>
      </v-card>
      <v-card class="mx-6 mt-4 col-md-5">
      <v-card-title class="montserrat primary--text font-weight-bold font30 text-center">
        Vos réservations
      </v-card-title>
      <v-col v-if="user.reserveds.length === 0" class="base--text montserrat text-center">
         Vous n'avez pas de réservations
        </v-col> 
      <v-col v-for="(res, i) in user.reserveds" :key="res.id">
      <v-card-text class="montserrat primary--text font20">
        {{ res.Book.title }}
      </v-card-text>
      <v-card-text class="base--text py-0">
        {{ res.Book.author }} ({{ $dayjs(res.Book.publicationDate).format('YYYY') }})
      </v-card-text>
      <v-card-text class="base--text">
        Disponible jusqu'au : {{ $dayjs(res.end).format('DD-MM-YYYY') }}
      </v-card-text>
      <hr class="base" :class="i + 1 === user.reserveds.length ? 'd-none' : ''"/>
      </v-col>
      </v-card>
  </v-row>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      user: null
    }
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'loggedInUser'])
  },
  mounted () {
    this.searchUserbyId ()
  },
  methods: {
      async searchUserbyId () {
        await this.$axios.$get('/api/users/' + this.loggedInUser.id + '.json')
        .then((response) => {
          this.user = response
        })
      }
  }
}
</script>
