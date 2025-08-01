<template>
    <v-card class="h-100 pa-4" elevation="3" rounded="lg">
        <v-card-title class="font-weight-bold text-primary">
            {{ title }}
        </v-card-title>
        <v-card-text class="text-medium-emphasis">
            <slot />
        </v-card-text>
    </v-card>
</template>

<script setup>
    defineProps({
        title: {
            type: String,
            required: true,
        },
    })
</script>