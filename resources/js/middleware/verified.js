export default function auth ({ next, store }){
    if(!store.getters.isEmailVerified) {
        return next({
            name: 'verify'
        });
    }
    return next();
}
