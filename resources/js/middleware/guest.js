export default function guest ({ next, store }){
    if(store.getters.isLoggedin){
        return next({
            name: 'orders'
        });
    }
    return next();
}
