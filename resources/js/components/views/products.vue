<template>
    <div>
        <div class="row py-3" v-if="products && products.length>0">
            <div class="col-12 col-sm-6 col-md-4 my-2" v-for="product in products" :key="product.id">
                <div class="card w-100 h-100 bg-dark text-light">
                    <div class="card-body">
                        <div class="card-text h5 text-warning-deep d-flex"><div class="flex-grow-1">{{ product.name }}</div> <div class="text-danger-deep d-flex justify-content-end align-items-start"><span class="p-1">${{ product.price }}</span> <a href="#" class="fa fa-plus border border-warning-deep p-1 text-light text-decoration-none" @click.prevent="addToCart(product)"></a></div></div>
                        <div>{{ product.description }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center text-secondary" v-else>
            <div class="col-12 text-center">
                <strong>Sorry!</strong> There are no products matching your search
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'products',
    data() {
        return {
            cart: this.$store.getters.cart,
            products: [],
            error: ''
        }
    },
    methods: {
        updateProducts: function () {
            var _this = this;
            axios.get('/api/products')
            .then(function (response) {
                if(response.data) {
                    _this.products = response.data;
                }
            })
            .catch(function (error) {
                if (error.response && error.response.status == 400) {
                    _this.error=error.response.data.message;
                } else {
                    _this.error = "An error occurred. Check your internet connection."
                }
            });
        },
        addToCart: function (product) {
            var is_same = false;
            for (let i = 0; i < this.cart.length; i++) {
                if (this.cart[i].id == product.id) {
                    this.cart[i].quantity = parseInt(this.cart[i].quantity) + 1;
                    is_same = true;
                    break;
                }
            }
            if (!is_same) {
                let p = {
                    "id": product.id,
                    "quantity": 1,
                    "price": product.price,
                    "name": product.name,
                };
                this.cart.unshift(p);
            }
            this.$store.dispatch("changeCart");
        }
    },
    mounted() {
        this.updateProducts();
    }
}
</script>
