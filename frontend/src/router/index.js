import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TeamBuilderView from '../views/TeamBuilderView.vue'
import DexView from '../views/DexView.vue'
import LoginView from '../views/LoginView.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/teambuilder',
        name: 'teambuilder',
        component: TeamBuilderView
    },
    {
        path: '/dex',
        name: 'dex',
        component: DexView
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router