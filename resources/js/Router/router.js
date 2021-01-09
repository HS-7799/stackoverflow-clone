import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from '../components/login/Login.vue'
import Register from '../components/login/Register.vue'

import Forum from '../components/forum/Forum.vue'
import ReadQuestion from '../components/forum/ReadQuestion.vue'
import CreateQuestion from '../components/forum/CreateQuestion.vue'
import CreateCategory from '../components/category/CreateCategory.vue'
import NotFound from '../components/NotFound.vue'
import Welcome from '../components/Welcome.vue'


Vue.use(VueRouter)

const routes = [
    { path: '/', component : Welcome, name: 'welcome' },
    { path: '/login', component: Login, name : 'login' },
    { path: '/register', component: Register, name : 'register' },
    { path: '/forum', component: Forum, name : 'forum' },
    { path: '/questions/:slug', component: ReadQuestion, name : 'readQuestion' },
    { path: '/ask', component: CreateQuestion, name : 'ask question' },
    { path: '/category', component: CreateCategory, name : 'category' },
    { path: '*', component: NotFound },


]


const router = new VueRouter({
    routes,
    mode : 'history'
});

export default router


