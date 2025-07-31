import API from './API.js'

export default {
  // Teams
  getTeams() {
    return API().get('teams.php')
  },
  getTeam(user_id) {
    return API().get(`teams.php?id=${user_id}`)
  },
  createTeam(payload) {
    return API().post('teams.php', payload)
  },
  deleteTeam(team_id) {
    return API().delete(`teams.php?id=${team_id}`)
  },

  // Likes
  getTeamLikes(team_id) {
    return API().get('team_likes.php', { params: { team_id } })
  },

  // PokeAPI
  getAllPokemon() {
    return API().get('pokemon.php')
  },
  getPokemon(nameOrId) {
    return API().get('pokemon_detail.php', {
      params: { name: nameOrId }
    })
  }
}