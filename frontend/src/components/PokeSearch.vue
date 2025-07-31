<template>
  <v-autocomplete :items="items" item-title="name" item-value="id" label="Select Pokémon"
  :model-value="modelValue" @update:modelValue="$emit('update:modelValue', $event)"
  />
</template>

<script setup>
  const props = defineProps({
    items: {type: Array, required: true },
    modelValue: Number
  })
  const emit = defineEmits(['update:modelValue'])
</script>