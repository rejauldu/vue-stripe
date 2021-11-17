<template>
    <div class="vh-50 d-flex justify-content-center flex-column text-light text-center bg-dark p-1 rounded">
        <div>
            <router-link to="/cart" class="text-light text-decoration-none">
                <span class="weight-25 height-25 bg-warning-deep rounded-circle d-inline-block">{{ quantity }}</span>
            </router-link>
        </div>
        <div class="h4"><router-link to="/cart" class="text-light text-decoration-none"><span>${{ price }}</span><i class="fa fa-shopping-cart"></i></router-link></div>
        <router-link to="/checkout" class="btn btn-success px-3 px-lg-5 grad border-0">Checkout</router-link>
    </div>
</template>

<script>
export default {
    name: 'cart',
    data() {
        return {
            cart: this.$store.getters.cart,
        }
    },
    computed: {
        price: function () {
            var p = 0;
            for(let i=0; i<this.cart.length; i++) {
                p+=this.cart[i].price*this.cart[i].quantity;
            }
            return p;
        },
        quantity: function () {
            var q = 0;
            for(let i=0; i<this.cart.length; i++) {
                q+=this.cart[i].quantity;
            }
            return q;
        },
    }
}
</script>
