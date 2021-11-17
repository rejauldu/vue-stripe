export default function auth ({ next, store }){
    if(!store.getters.isLoggedin) {
        return next({
            name: 'login'
        });
    }
    return next();
}
