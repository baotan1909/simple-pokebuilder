<template>
    <section :class="['py-12', background]">
        <v-row align="center" no-gutters :class="{ 'flex-md-row-reverse': reverse }">
            <v-col cols="12" md="6" class="d-flex justify-center px-4 px-md-12">
                <div class="w-100" style="max-width: 1280px;">
                    <slot name="image" />
                </div>
            </v-col>
            <v-col cols="12" md="6" class="d-flex flex-column align-center align-md-start text-center text-md-start px-4 px-md-12">
                <slot />
            </v-col>
        </v-row>
    </section>
</template>

<script setup>
defineProps({
  reverse: Boolean,
  background: {
    type: String,
    default: '',
  }
})
</script>