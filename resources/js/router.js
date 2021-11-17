import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import middlewarePipeline from './middleware/middlewarePipeline'

Vue.use(Router)

import products from './components/views/products'
import cart from './components/views/cart'
import checkout from './components/views/checkout'
import orderComplete from './components/views/order-complete'

const routes = [
    {
        path:'/', name:'products', component: products,
    },
    {
        path:'/cart', name:'cart', component: cart,
    },
    {
        path:'/checkout', name:'checkout', component: checkout,
    },
    {
        path:'/order-complete', name:'order-complete', component: orderComplete,
    },
	{
		path:'*', component: products,
	}
];
const router = new Router({
	mode: 'history',
	linkActiveClass: 'active',
	routes
});
router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }
    const middleware = to.meta.middleware

    const context = {
        to,
        from,
        next,
        store
    }
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    })

});
export default router;
