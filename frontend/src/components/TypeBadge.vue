<template>
    <span
    v-for="(type, i) in types"
    :key="i"
    class="ma-1 type-badge"
    :class="type.toLowerCase()"
    >
        {{ type }}
    </span>
</template>

<script setup>
    defineProps({
        types: Array
    })
</script>

<style scoped>
    .type-badge {
        display: inline-block;
        min-width: 90px;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        text-transform: capitalize;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        letter-spacing: 0.5px;
        user-select: none;
        transition: transform 0.2s;
        text-align: center;
    }

    .normal   { background-color: #A8A77A; }
    .fire     { background-color: #EE8130; }
    .water    { background-color: #6390F0; }
    .electric { background-color: #F7D02C; color: black; }
    .grass    { background-color: #7AC74C; }
    .ice      { background-color: #96D9D6; color: black; }
    .fighting { background-color: #C22E28; }
    .poison   { background-color: #A33EA1; }
    .ground   { background-color: #E2BF65; color: black; }
    .flying   { background-color: #A98FF3; }
    .psychic  { background-color: #F95587; }
    .bug      { background-color: #A6B91A; }
    .rock     { background-color: #B6A136; color: black; }
    .ghost    { background-color: #735797; }
    .dragon   { background-color: #6F35FC; }
    .dark     { background-color: #705746; }
    .steel    { background-color: #B7B7CE; color: black; }
    .fairy    { background-color: #D685AD; }
    .unknown  { background-color: red; }
</style>