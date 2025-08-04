<template>
  <v-autocomplete :items="items" item-title="name" item-value="id" label="Select Pokémon"
  aria-label="Pokemon selector" aria-describedby="pokemon-autocomplete-desc" clearable 
  :model-value="modelValue" @update:modelValue="$emit('update:modelValue', $event)"/>
  <span :id="ariaDescriptionId" class="sr-only">
    Use arrow keys to navigate and Enter to select. This field is searchable.
  </span>
</template>

<script setup>
  const props = defineProps({
    items: {type: Array, required: true },
    modelValue: Number
  })
  const emit = defineEmits(['update:modelValue'])
</script>

<style scoped>
  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
  }
</style>