export default function auth ({ next, store }){
    if(store.getters.isEmailVerified) {
        return next({
            name: 'orders'
        });
    }
    return next();
}
