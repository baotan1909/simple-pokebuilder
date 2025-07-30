<template>
    <v-card class="pa-4 mb-4 rounded-xl" elevation="3">
        <v-card-title class="text-h6 font-weight-bold">
        {{ team.name }}
        </v-card-title>

        <v-divider class="my-2" />

        <v-row justify="center" class="pokemon-list mb-2 flex-wrap" style="overflow-x: auto;">
            <v-col
            v-for="(p, i) in team.pokemons"
            :key="i"
            cols="auto"
            class="d-flex justify-center"
            >
                <img
                :src="`https://img.pokemondb.net/sprites/home/normal/${p?.species || '0'}.png`"
                :alt="p?.species || 'Unknown'"
                width="64"
                height="64"
                />
            </v-col>
        </v-row>

        <v-divider class="my-2" />

        <v-row align="center" class="mt-1">
            <v-col cols="auto" class="d-flex align-center">
                <v-icon icon="mdi-heart" color="red" start />
                <span class="ml-1 font-weight-medium">{{ team.likes_count }} Likes</span>
            </v-col>
        </v-row>
    </v-card>
</template>

<script setup>
    defineProps({
        team: {
            type: Object,
            required: true,
            validator: (t) =>
            typeof t.id === 'number' &&
            Array.isArray(t.pokemons) &&
            typeof t.name === 'string'
        }
    })
</script>