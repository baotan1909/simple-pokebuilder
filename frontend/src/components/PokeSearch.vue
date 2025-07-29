<template>
    <v-autocomplete
    :items="items"
    item-title="name"
    item-value="id"
    label="Select Pokemon"
    @update:modelValue="$emit('select', $event)"
    />
</template>

<script setup>
  const props = defineProps({
    items: {
      type: Array,
      required: true
    }
  })  
</script>