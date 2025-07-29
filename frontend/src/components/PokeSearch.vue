<template>
    <v-autocomplete
      :items="items"
      label="Select Pokemon"
      no-data-text="No Pokemon found."
    />
  </template>
  
<script setup>
    defineProps({
        items: {
            type: Array,
            required: true
        }
    })
</script>  