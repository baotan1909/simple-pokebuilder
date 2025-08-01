<template>
    <v-sheet height="100vh" color="blue-lighten-4" class="d-flex flex-column align-center justify-center text-center" elevation="0">
        <h1 class="text-h2 font-weight-bold mb-4" v-html="headingText"></h1>
        <p class="text-subtitle-1 mb-6">{{ subText }}</p>
        <v-btn color="primary" size="large" variant="elevated" @click="handleButtonClick">
            {{ buttonText }}
        </v-btn>
    </v-sheet>
</template>

<script setup>
    import { computed, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import auth from '../composables/auth.js'

    const router = useRouter()
    const { isAuthenticated, user, checkAuth } = auth
    
    const headingText = computed(() => isAuthenticated.value
        ? `Welcome back,<br>${user.value?.name || 'Trainer'}!`
        : 'Welcome to<br>Simple Pokemon Teambuilder.')

    const subText = computed(() =>
    isAuthenticated.value
        ? 'Ready to build or refine your team?'
        : 'Create and share your Pokemon team with ease.'
    )

    const buttonText = computed(() => isAuthenticated.value ? 'Go to TeamBuilder' : 'Login')
    const handleButtonClick = () => { router.push(isAuthenticated.value ? '/teambuilder' : '/login') }

    onMounted(() => {
        checkAuth()
    })
</script>

<style scoped>
    .fill-height {
        min-height: calc(100vh - 200px);
    }
</style>