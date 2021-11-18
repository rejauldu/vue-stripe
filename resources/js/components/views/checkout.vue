<template>
    <div class="row vh bg-dark">
        <div class="col-12 text-center text-light ">
            <h2 CLASS="mt-3 mt-md-5 mb-3 mb-md-5"><span class="border border-secondary border-top-0 border-start-0 border-end-0" style="border-style: dotted !important;">CHECKOUT</span></h2>
            <p>YOUR PERSONAL AND FINANCIAL INFORMATION ARE TRANSMITTED</p>
            <p>OVER SSL SECURED CONNECTION USING 256 BIT BANK LEVEL ENCRYPTION</p>
            <div><button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#myModal">Pay with Stripe Checkout</button></div>
            <div class="mt-2"><img src="images/cards.png" class="mw-100"/></div>
        </div>
        <div class="col-12">
            <div class="modal" id="myModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-bottom-0 pb-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center px-4 pb-4 pt-0">
                            <div class="text-secondary mb-3">Stripe Online Payment</div>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-white fa fa-envelope-o d-flex align-items-center"></span>
                                <input type="text" ref="email" class="border-start-0 border-end-0 form-control shadow-none" placeholder="Email">
                                <span class="input-group-text bg-white fa fa-address-card-o d-flex align-items-center"></span>
                            </div>
                            <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>

                            <!-- Used to display Element errors. -->
                            <div id="card-errors" role="alert"></div>
                            <div>
                                <button type="button" class="btn btn-primary px-4 w-100" @click="processPayment()" :disabled="processing" v-text="processing?'Processing...':'Pay with Card $'+total"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {loadStripe} from '@stripe/stripe-js';
export default {
    name: 'home',
    data() {
        return {
            stripe: {},
            cardElement: {},
            cart: this.$store.getters.cart,
            name: '',
            processing: false,
            error: ''
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
            return this.subTotal+this.subTotal*20/100;
        }
    },
    methods: {
        async processPayment(){
            this.processing = true;
            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        email: this.$refs.email.value
                    }
                }
            );
            if(error) {
                this.processing = false;
                alert(error);
            } else {
                axios.post('api/purchase', {
                    email: this.$refs.email.value,
                    payment_method_id: paymentMethod.id,
                    amount: this.total,
                    products: this.cart
                }).then( (response) => {
                    this.processing = false;
                    var element = document.querySelector('.modal-backdrop');
                    element.parentNode.removeChild(element);
                    this.$router.push({ name: 'order-complete'});
                }).catch((error) => {
                    this.processing = false;
                    alert(error);
                });
            }
        },
    },
    async mounted() {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'py-2 mb-4 border border-color rounded padding'
            }
        });
        this.cardElement.mount('#card-element');
    }
}
</script>
<style scoped>
.border-color {
    border: 1px solid #ced4da !important;
}
.padding {
    padding-left: 12px;
    padding-right: 12px;
}
</style>
