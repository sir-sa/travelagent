import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    { path: '/', component: AccommodationList },
    { path: '/accommodations/:id', component: AccommodationDetails },
    { path: '/booking', component: BookingForm },
];

const router = new VueRouter({
    routes,
    mode: 'history', // Enable HTML5 history mode
});

export default router;