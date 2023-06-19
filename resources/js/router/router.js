import { createRouter, createWebHistory } from 'vue-router';
import Admin from '../components/Admin.vue';
import Header from '../components/Header.vue';
import App from '../components/App.vue';
import ButtonComponent from '../components/ButtonComponent.vue';
import Register from '../components/Register.vue';
import Marks from '../components/Marks.vue';
import Users from '../components/Users.vue';
import UsersCreate from '../components/UsersCreate.vue';
import UserProfile from '../components/UserProfile.vue';
import Dashboard from '../components/Dashboard.vue';
import Configurate from '../components/Configurate.vue';
import TimeTable from '../components/TimeTable.vue';
import Subjects from '../components/Subjects.vue';
import AllTimeTable from '../components/AllTimeTable.vue'; 
import AdminTable from '../components/AdminTable.vue';
import Lessons from '../components/Lessons.vue';
import Home from '../components/Home.vue';
const routes = [
    {
        path: '/admin',
        component: Admin
    },
    {
        path:'/home',
        component: Home
    },
    {
        path:'/',
        component:Admin
    },
    {
        path:'/button',
        component:ButtonComponent
    },
    {
        path:'/registr',
        component:Register
    },
    {
        path:'/home/marks',
        component:Marks
    },
    {
        path:'/home/dashboard',
        component:Dashboard
    },
    {
        path:'/home/users',
        component:Users
    },
    {
        path:'/home/users/create',
        component:UsersCreate
    },
    {
        path: '/profile/:id',
        component: UserProfile
    },
    {
        path:'/configurate',
        component:Configurate
    },
    {
        path:'/home/timetable',
        component:TimeTable
    },
    {
        path:'/home/subjects',
        component:Subjects
    },
    {
        path:'/allTimeTable',
        component:AllTimeTable
    },
    {
        path:'/adminTimeTable',
        component:AdminTable
    },
    {
        path:'/home/lessons',
        component:Lessons
    },
];
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})
export default router;
