<template>
  <v-container>
    <h1 class="mb-4">Your Stored Teams</h1>
    <v-alert v-if="!isAuthenticated || noTeam" type="info" variant="tonal" class="mb-4">
      {{ alertMessage }}
    </v-alert>

    <v-row>
      <v-col v-for="team in displayTeams" :key="team.id" cols="12" md="6">
        <PokeBox :team="team">
          <template #actions>
            <div class="d-flex align-center">
              <EditButton @click="openEditWindow(team)"/>
              <DeleteButton :team-id="team.id" @delete="delTeam" />
            </div>
          </template>

          <template #info>
            <v-icon icon="mdi-heart" color="red" start />
            <span class="ml-1 font-weight-medium">{{ team.likes }} Likes</span>
          </template>
        </PokeBox>
      </v-col>
    </v-row>
    <EditTeamWindow v-model="showDialog" :team="teamToEdit" @edited="loadTeams" />
  </v-container>
</template>

<script setup>
  import { ref, computed, onMounted, watch } from 'vue'
  import auth from '../composables/auth.js'
  import PokeAPI from '../services/PokeAPI.js'
  import PokeBox from '../components/PokeBox.vue'
  import EditButton from './EditButton.vue'
  import DeleteButton from './DeleteButton.vue'
  import EditTeamWindow from './EditTeamWindow.vue'
  
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

  const showDialog = ref(false)
  const teamToEdit = ref(null)

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
  
  async function delTeam(team_id) {
    try {
      await PokeAPI.deleteTeam(team_id)
      loadTeams()
    } catch (err) {
      console.error('Failed to delete team:', err)
    }
  }

  function openEditWindow(team) {
    teamToEdit.value = team
    showDialog.value = true
  }

  watch([isAuthenticated, user], ([auth, usr]) => {
    if (auth && usr?.id) {
      loadTeams()
    }
  })

  onMounted(() => { loadTeams() })
</script>