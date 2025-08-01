<template> 
  <v-row>
    <v-col v-for="team in teams" :key="team.id" cols="12" md="6">
      <PokemonBox :team="team">
        <template #actions>
            <div class="d-flex align-center ga-1">
            <v-btn icon color="red" @click="likeTeam(team)" :disabled="likedTeams.has(team.id)">
              <v-icon>
                {{ likedTeams.has(team.id) ? 'mdi-heart' : 'mdi-heart-outline' }}
              </v-icon>
            </v-btn>
            <span class="text-caption text-grey-darken-1">{{ likeCounts[team.id] ?? 0 }}</span>
          </div>
        </template>

        <template #info>
          <span class="text-caption"><strong>Author:</strong> {{ displayAuthor(team) }}</span>
        </template>
      </PokemonBox>
    </v-col>
  </v-row>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/PokeAPI.js'
import auth from '../composables/auth.js'
import { useNotify } from '../composables/useNotify.js'
import PokemonBox from '../components/PokemonBox.vue'

const teams = ref([])
const likedTeams = ref(new Set())
const likeCounts = ref({})
const { notify } = useNotify()

async function loadTeams() {
  try {
    const res = await api.getTeams()
    teams.value = res.data
    await loadTeamLikes(res.data)
  } catch (err) {
    console.error('Failed to load teams:', err)
  }
}

async function loadTeamLikes(teamList) {
  for (const team of teamList) {
    try {
      const response = await api.getTeamLikes(team.id)
      likeCounts.value[team.id] = response.data.likes ?? 0
    } catch (err) {
      likeCounts.value[team.id] = 0
      console.error(`Failed to get likes for team ${team.id}`, err)
    }
  }
}

function displayAuthor(team) {
    const userId = auth.user.value?.id

    const isOwnTeam = team.user_id === userId
    if (isOwnTeam) { return 'You'}
    return team.user_name || 'Unknown'
}

async function likeTeam(team) {
  if (!auth.isAuthenticated.value) {
    notify('Please log in to like team.')
    return
  }
  
  const userId = auth.user.value?.id
  if (!userId) {
    notify('User not found.')
    return
  }

  if (team.user_id === userId) {
    notify("You can't like your own team.")
    return
  }
  
  try {
    await api.createLike(userId, team.id)
    likedTeams.value.add(team.id)
  } catch (error) {
    const status = error.response?.status
    if (status === 409) {
      notify("You already liked this team.")
    } else {
      notify('Something went wrong while liking.')
      console.error(error)
    }
  }
}

onMounted(loadTeams)
</script>