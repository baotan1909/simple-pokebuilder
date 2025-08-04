<template>
    <v-btn aria-label="Save your changes" color="primary" size="large" variant="flat" prepend-icon="mdi-content-save"
    @click="$emit('save')">
      Save
    </v-btn>
</template>