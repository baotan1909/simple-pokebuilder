<template>
  <v-container>
    <h1 class="mb-4">Your Stored Teams</h1>

  <v-alert v-if="!isAuthenticated || noTeam" type="info" variant="tonal" class="mb-4">
      {{ alertMessage }}
    </v-alert>

    <v-row>
  <v-col v-for="team in displayTeams" :key="team.id" cols="12" md="6">
    <PokemonBox :team="team">
      <template #actions>
        <div class="d-flex align-center">
          <v-btn icon variant="text" color="primary" class="mr-2">
            <v-icon>mdi-pencil</v-icon>
          </v-btn>
          <v-btn icon variant="text" color="error">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </div>
      </template>

      <template #info>
        <v-icon icon="mdi-heart" color="red" start />
        <span class="ml-1 font-weight-medium">{{ team.likes }} Likes</span>
      </template>
    </PokemonBox>
  </v-col>
</v-row>
  </v-container>
</template>

<script setup>
  import { ref, computed, onMounted, watch, defineExpose } from 'vue'
  import auth from '../composables/auth.js'
  import PokeAPI from '../services/PokeAPI.js'
  import PokemonBox from '../components/PokemonBox.vue'
  
  defineExpose({ loadTeams })

  const { isAuthenticated, user } = auth
  const teams = ref({})

  const noTeam = computed(() => Object.keys(teams.value).length === 0)
  const teamList = computed(() => Object.values(teams.value))
  const displayTeams = computed(() => isAuthenticated.value && !noTeam.value ? teamList.value : [])
  const alertMessage = computed(() =>
    !isAuthenticated.value
      ? 'You need to log in to create and view your teams.'
      : "You haven't created any teams yet."
  )

  async function loadTeams() {
    if (!isAuthenticated.value || !user.value?.id) { return }

    try {
      const res = await PokeAPI.getTeam(user.value.id)
        const detailedTeams = {}
        for (const team of res.data) {
          let likes = []
          try {
            const likesRes = await PokeAPI.getTeamLikes(team.id)
            likes = likesRes.data.like_count
          } catch (e) {
            console.error(`Failed to get likes for team ${team.id}`, e)
          }
            detailedTeams[team.id] = {
            ...team,
            likes,
          }
        }
        teams.value = detailedTeams
    } catch (err) {
      console.error('Failed to load teams or likes:', err)
    }
  }

  watch([isAuthenticated, user], ([auth, usr]) => {
    if (auth && usr?.id) {
      loadTeams()
    }
  })

  onMounted(() => { loadTeams() })
</script>