<template> 
  <v-row>
    <v-col v-for="team in teams" :key="team.id" cols="12" md="6">
      <PokemonBox :team="team">
        <template #actions>
            <div class="d-flex align-center ga-1">
            <v-btn icon color="red" @click="likeTeam(team)">
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
      const detailedTeams = []
      
      for (const team of res.data) {
        let likes = 0
        try {
          const likesRes = await api.getTeamLikes(team.id)
          likes = likesRes.data.like_count ?? 0
        } catch (e) {
          console.error(`Failed to get likes for team ${team.id}`, e)
        }

        detailedTeams.push({
          ...team,
          likes,
        })

        if (likes > 0 && team.user_id !== auth.user.value?.id) {
          likedTeams.value.add(team.id)
        }

        likeCounts.value[team.id] = likes
      }

      teams.value = detailedTeams
    } catch (err) {
      console.error('Failed to load teams:', err)
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

    const isLiked = likedTeams.value.has(team.id)

    try {
      if (isLiked) {
        await unlikeTeam(team)
        likeCounts.value[team.id] = Math.max((likeCounts.value[team.id] ?? 1) - 1, 0)
      } else {
        await api.createLike(userId, team.id)
        likedTeams.value.add(team.id)
        likeCounts.value[team.id] = (likeCounts.value[team.id] ?? 0) + 1
      }
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
  
  async function unlikeTeam(team) {
    const userId = auth.user.value?.id
    if (!userId) {
      notify('User not found.')
      return
    }

    try {
      await api.deleteLike(userId, team.id)
      likedTeams.value.delete(team.id)
    } catch (error) {
      notify('Something went wrong while unliking.')
      console.error(error)
    }
  }

  onMounted(loadTeams)
</script>