<template>
    <div class="row vh bg-dark">
        <div class="col-12">
            <table class="table table-bordered text-light mt-3 mt-md-5">
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
                    <td class="text-center">${{ product.price*product.quantity }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">SUB TOTAL</td>
                    <td class="text-center">${{ subTotal }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">TAX 20%</td>
                    <td class="text-center">${{ subTotal*20/100 }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">TOTAL</td>
                    <td class="text-center">${{ total }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'home',
    data() {
        return {
            cart: this.$store.getters.cart,
        }
    },
    computed: {
        subTotal: function () {
            var p = 0;
            for(let i=0; i<this.cart.length; i++) {
                p+=this.cart[i].price*this.cart[i].quantity;
            }
            return p;
        },
        total: function () {
            return this.subTotal-this.subTotal*20/100;
        }
    }
}
</script>
