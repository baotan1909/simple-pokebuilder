<template>
    <!-- Full Banner -->
    <v-sheet height="100vh" color="blue-lighten-4" class="d-flex flex-column align-center justify-center text-center" elevation="0">
        <h1 class="text-h2 font-weight-bold mb-4" v-html="headingText" />
        <p class="text-subtitle-1 mb-6">{{ subText }}</p>
        <v-btn color="primary" size="large" variant="elevated" @click="handleButtonClick">
            {{ buttonText }}
        </v-btn>
    </v-sheet>

    <!-- About Section -->
    <v-container class="py-12">
        <v-row justify="center">
            <v-col cols="12" md="8" class="text-center">
            <h2 class="text-h4 font-weight-bold mb-4">About This App</h2>
                <p class="text-subtitle-1">
                Simple Pokémon TeamBuilder helps trainers of all levels easily create, manage, and share their Pokémon teams.
                Whether you're preparing for competitive battles or just organizing your favorites, this tool is for you.
                </p>
            </v-col>
        </v-row>
    </v-container>

    <!-- Teambuilder Section -->
    <FeatureSection background="bg-blue-lighten-4">
        <template #image>
            <v-img src="/img/teambuilder_screenshot.png" alt="Teambuilder preview" cover />
        </template>
        <h3 class="text-h5 font-weight-bold mb-2">Build Your Dream Team</h3>
        <p class="text-subtitle-1 mb-4">
            Use the intuitive team builder to select your favorite Pokémon, customize their moves, assign roles, and fine-tune strategies
            for any battle scenario. Whether you're preparing for competitive play or crafting your dream lineup just for fun, our clean and
            simple interface makes the entire process fast, flexible, and enjoyable.
        </p>
        <v-btn color="primary" @click="router.push('/teambuilder')">Try the Builder</v-btn>
    </FeatureSection>

    <!-- All teams section -->
    <FeatureSection reverse>
        <template #image>
            <v-img src="/img/allTeams_screenshot.png" alt="All teams preview" cover />
        </template>
        <h3 class="text-h5 font-weight-bold mb-2">See Other Trainers’ Teams</h3>
        <p class="text-subtitle-1 mb-4">
            Browse a growing collection of community-submitted teams to find inspiration, discover creative teams, or simply explore what
            other trainers are building. Like your favorites, and contribute your own team to become part of the conversation.
            Whether you're a casual fan or a seasoned battler, there's something for everyone to enjoy.
        </p>
        <v-btn color="primary" @click="router.push('/social')">Browse Teams</v-btn>
    </FeatureSection>

    <!-- Contact Form -->
    <ContactForm />
</template>

<script setup>
    import { computed, onMounted } from 'vue'
    import { useRouter } from 'vue-router'
    import auth from '../composables/auth.js'
    import FeatureSection from '../components/FeatureSection.vue'    
    import ContactForm from '../components/ContactForm.vue'

    const router = useRouter()
    const { isAuthenticated, user, checkAuth } = auth

    const headingText = computed(() => isAuthenticated.value
        ? `Welcome back,<br>${user.value?.name || 'Trainer'}!`
        : 'Welcome to<br>Simple Pokemon Teambuilder.')

    const subText = computed(() => isAuthenticated.value
        ? 'Ready to build or refine your team?'
        : 'Create and share your Pokemon team with ease.')

    const buttonText = computed(() => isAuthenticated.value ? 'Go to TeamBuilder' : 'Login for Full Access')

    const handleButtonClick = () => {router.push(isAuthenticated.value ? '/teambuilder' : '/login')}

    onMounted(() => { checkAuth()})
</script>

<style scoped>
    .fill-height {
        min-height: calc(100vh - 200px);
    }
</style>