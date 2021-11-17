<template>
    <div class="row vh bg-dark">
        <div class="col-12 text-light">
            <h2 class="display-5 text-center mt-3 mt-md-5">Thank your for your order!</h2>
            <div class="display-5 text-center">Order Summary</div>
            <table class="table table-bordered mt-3 mt-md-5 text-light">
                <thead>
                <tr>
                    <th>ITEM</th>
                    <th class="text-center">UNIT PRICE</th>
                    <th class="text-center">QUANTITY</th>
                    <th class="text-center">LINE TOTAL</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in cart">
                    <td>{{ product.name }}</td>
                    <td class="text-center">${{ product.price }}</td>
                    <td class="text-center">{{ product.quantity }}</td>
                    <td class="text-center">${{ product.price * product.quantity }}</td>
                </tr>
                <tr>
                    <td colSpan="3" class="text-center">SUB TOTAL</td>
                    <td class="text-center">${{ subTotal }}</td>
                </tr>
                <tr>
                    <td colSpan="3" class="text-center">TAX 20%</td>
                    <td class="text-center">${{ subTotal * 20 / 100 }}</td>
                </tr>
                <tr>
                    <td colSpan="3" class="text-center">TOTAL</td>
                    <td class="text-center">${{ total }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'order-complete',
    data() {
        return {
            cart: this.$store.getters.cart,
        }
    },
    computed: {
        subTotal: function () {
            var p = 0;
            for (let i = 0; i < this.cart.length; i++) {
                p += this.cart[i].price * this.cart[i].quantity;
            }
            return p;
        },
        total: function () {
            return this.subTotal + this.subTotal * 20 / 100;
        }
    },
    mounted() {
        this.$store.dispatch("clearCart");
    }
}
</script>
