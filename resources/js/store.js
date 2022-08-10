import Swal from "sweetalert2";

let cart = window.localStorage.getItem("cart");
let cartCount = window.localStorage.getItem("cartCount");
let store = {
    state: {
        cart: cart ? JSON.parse(cart) : [],
        cartCount: cartCount ? parseInt(cartCount) : 0
    },
    mutations: {
        addToCart(state, item) {
            let found = state.cart.find(
                product => product.product_id == item.product_id
            );
            var languageUsed = document.documentElement.lang; // Get the value of lang
            if (found) {
                found.quantity++;
                found.totalPrice = found.quantity * found.product_price;
            } else {
                state.cart.push(item);

                Vue.set(item, "quantity", 1);
                if (item.product_sale_price == null) {
                    Vue.set(item, "totalPrice", item.product_price);
                }
                else {
                    Vue.set(item, "totalPrice", item.product_sale_price);
                }

            }
            if(languageUsed == 'en') {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "Product added to cart",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: "تم إضافة المنتج إلى عربة التسوق",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            
            state.cartCount++;
            this.commit("saveCart");
        },
        updateCart(product, e)
        {
            this.quantity = parseInt(e.target.value);
            this.$store.dispatch('UPDATE_CART',{ product, quantity: this.quantity })
        },
        removeFromCart(state, item) {
            let index = state.cart.indexOf(item);
            var languageUsed = document.documentElement.lang; // Get the value of lang
            if (index > -1) {
                let product = state.cart[index];
                state.cartCount -= product.quantity;

                state.cart.splice(index, 1);
            }
            if(languageUsed == 'en') {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "warning",
                    title: "Product removed from cart",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "warning",
                    title: "تم حذف المنتج من عربة التسوق",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            this.commit("saveCart");
        },
        saveCart(state) {
            window.localStorage.setItem("cart", JSON.stringify(state.cart));
            window.localStorage.setItem("cartCount", state.cartCount);
        }
    }
};

export default store;
