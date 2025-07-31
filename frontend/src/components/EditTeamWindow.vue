<template>
    <v-dialog :model-value="modelValue" @update:modelValue="emit('update:modelValue', $event)" max-width="1600px" persistent>
        <v-card>
            <v-card-title class="text-h5 font-weight-bold text-center justify-center">
            Edit Team
            </v-card-title>

            <v-card-text>
                <v-row justify="center" class="mb-4">
                    <v-col cols="12" v-if="error">
                        <v-alert type="error" variant="tonal" class="mx-auto" max-width="400">
                            {{ error }}
                        </v-alert>
                    </v-col>
                </v-row>

                <v-row class="mb-4" align="center" justify="center">
                    <v-col cols="8" md="10">
                        <v-text-field v-model="newName" label="Team Name" variant="outlined" density="comfortable" hide-details/>
                    </v-col>
                    <v-col cols="4" md="2">
                        <SaveButton @save="saveTeam" />
                    </v-col>
                </v-row>

                <v-row dense v-if="!error">
                    <v-col v-for="i in 6" :key="i" cols="12" xs="6" sm="4" md="2">
                        <v-card elevation="4" class="pa-3 d-flex flex-column align-center">
                            <PokeSearch :items="items" v-model="selected[i - 1].dex_number" class="mb-2 w-100" />
                            <PokeDisplay :pokemon="selected[i - 1].dex_number" />
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-actions class="justify-end">
                <v-btn text @click="close">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
  
<script setup>
    import { ref, onUpdated, onMounted } from 'vue'
    import { useNotify } from '../composables/useNotify.js'
    import PokeAPI from '../services/PokeAPI'
    import SaveButton from './SaveButton.vue'
    import PokeSearch from './PokeSearch.vue'
    import PokeDisplay from './PokeDisplay.vue'

    const props = defineProps({
        team: Object,
        modelValue: Boolean,
    })
    const emit = defineEmits(['update:modelValue'])

    const newName = ref('')
    const selected = ref(Array(6).fill({ dex_number: null }))
    const error = ref(null)
    const items = ref([])
    const { notify, confirm } = useNotify()

    function initFromProps() {
        if (props.modelValue && props.team) {
            newName.value = props.team.name || ''
            selected.value = Array(6)
                .fill()
                .map((_, i) => {
                    const p = props.team.pokemons?.[i]
                    const value = p?.dex_number ?? null
                    return {
                        dex_number: value === 0 ? null : value,
                        species: p?.species ?? 'Unknown'
                    }
                })
        }
    }

    async function loadItems() {
        try {
            const response = await PokeAPI.getAllPokemon()
            items.value = response.data.pokemon_species.map(p => {
                const id = p.url.match(/\/(\d+)\//)[1]
                return {
                    id: parseInt(id),
                    name: p.name.charAt(0).toUpperCase() + p.name.slice(1)
                }
            })
        } catch (err) {
            console.error(err)
            error.value = 'Failed to load Pokemon.'
        }
    }

    const saveTeam = async () => {
        if (!props.team?.id) {
            notify('Missing team ID.')
            return
        }

        if (!newName.value.trim()) {
            newName.value = 'Untitled'
        }

        const proceed = confirm(`Are you sure you want to save team ${newName.value}?`)
        if (!proceed) { return }

        const payload = {
            name: newName.value.trim(),
            pokemons: selected.value.map(p => ({
                dex_number: p?.dex_number ?? 0,
                species: p?.species ?? 'Unknown'
            }))
        }

        try {
            const response = await PokeAPI.updateTeam(props.team.id, payload)
            if (response.data.success) {
                notify('Team updated successfully!')
                close()
            } else {
                notify('Failed to update team.')
            }
        } catch (err) {
            console.error(err)
            notify('Something went wrong while saving.')
        }
    }

    const close = () => {
        emit('update:modelValue', false)
        newName.value = ''
        selected.value = Array(6).fill({ dex_number: null })
    }

    onMounted(() => loadItems())
    
    onUpdated(() => {
        if (props.modelValue) {
            initFromProps()
        }
    })
</script>