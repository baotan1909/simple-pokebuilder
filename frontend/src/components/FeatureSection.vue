<template>
    <v-container class="py-12">
        <v-row align="center" :class="{ 'flex-md-row-reverse': reverse }">
            <v-col cols="12" md="6">
                <slot name="image" />
            </v-col>
            <v-col cols="12" md="6">
                <slot />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
    defineProps({
        reverse: Boolean,
    })
</script>