import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
	state: {
        cart: JSON.parse(localStorage.cart || '[]')
	},
	getters: {
        cart: (state) => {
            return state.cart;
        }
	},
	actions: {
        changeCart(context, data = null) {
            context.commit("changeCart", data);
        },
        clearCart(context) {
            context.commit("clearCart");
        }
	},
	mutations: {
        changeCart(state, data=null) {
	        if(data)
	            state.cart = data;
            localStorage.cart = JSON.stringify(state.cart);
        },
        clearCart(state) {
            state.cart = [];
            localStorage.cart = JSON.stringify(state.cart);
        }
	}
});
