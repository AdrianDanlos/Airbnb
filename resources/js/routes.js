//When the php router returns a view to the frontend, VUE router takes control of the application and decides what to show.

import VueRouter from "vue-router";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";
import Review from "./review/Review";
import Basket from "./basket/Basket"
import Login from "./auth/Login";

const routes = [{
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable",
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review",
    },
    {
        path: "/basket",
        component: Basket,
        name: "basket"
    },
    {
        path: "/auth/login",
        component: Login,
        name: "login"
    },
    {
        path: "/auth/register",
        component: require("./auth/Register").default, //the old way of importing components
        name: "register"
    }
]

//We create a router object with our routes and export it to reference it in app.js
const router = new VueRouter({
    routes, // shorthand for `routes: routes`
    mode: 'history', //to get rid of hash in url
})

export default router;
