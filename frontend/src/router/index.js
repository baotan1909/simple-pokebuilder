import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TeamBuilderView from '../views/TeamBuilderView.vue'
import DexView from '../views/DexView.vue'

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
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router