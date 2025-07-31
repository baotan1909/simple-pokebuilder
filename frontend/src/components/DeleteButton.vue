<template>
    <v-btn icon variant="text" color="error" @click="confirmDelete">
      <v-icon>mdi-delete</v-icon>
    </v-btn>
</template>

<script setup>
import { useNotify } from '../composables/useNotify.js'

const props = defineProps({
  teamId: { type: Number, required: true }
})

const emit = defineEmits(['delete'])

const { confirm } = useNotify()

function confirmDelete() {
  if (confirm('Are you sure you want to delete this team?')) {
    emit('delete', props.teamId)
  }
}
</script>