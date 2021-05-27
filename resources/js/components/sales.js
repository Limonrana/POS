if (document.querySelector('.sales')) {
    let productForm = new Vue({
        el: ".sales",
        delimiters: ['${', '}'],

        data() {
            return {
                cart: [],
                customer: [],
                p: 1,
                freight: '00.00',
                paid: '00.00',
                vat: '00.00',
                discount: '0'
            }
        },

        computed: {
            subtotal() {
                let sum = 0;
                for (let i =0; i < this.cart.length; i++) {
                    sum += (parseFloat(this.cart[i].subtotal));
                }
                return sum;
            },
            total() {
                let discount = this.subtotal * parseFloat(this.discount) / 100;
                let left = this.subtotal - discount;
                let t_ammount = parseFloat(this.freight) + parseFloat(this.vat) + left;
                let t_round_balance = (Math.round(t_ammount * 100) / 100).toFixed(2);
                return t_round_balance;
            },
            balance() {
                let credit_balance =  parseFloat(this.total) - parseFloat(this.paid);
                let round_balance = (Math.round(credit_balance * 100) / 100).toFixed(2);
                return round_balance;
            }
        },
        created() {
            this.AllCarts();
        },

        methods: {
            productId() {
                let productID = document.getElementById('product_id').value;
                return productID;
            },
            AllCarts() {
                var currentUrl = window.location.pathname;
                var data_split = currentUrl.split("/");
                var url = data_split[1];
                axios.get('/getCart/' + url )
                    .then(data => {
                        this.cart = data.data
                    })
                    .catch()
            },
            addCart() {
                var currentUrl = window.location.pathname;
                axios.post('/cart', { id: this.productId(), url: currentUrl })
                    .then(response => {
                        if (response.data == "Product stock out.") {
                            toastr.warning(response.data);
                        } else {
                            var product_form = document.getElementById('add-product');
                            product_form.classList.remove('show');
                            this.AllCarts();
                            toastr.success("Product added to cart");
                        }
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            cartRemove(id) {
                axios.delete('/cart/' + id)
                    .then(response => {
                        this.AllCarts();
                        toastr.success("Product removed from cart");
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            increment(id) {
                axios.put('/cart/' + id)
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllCarts();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            decrement(id) {
                axios.post('/cart-update/' + id)
                    .then(response => {
                        this.AllCarts();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            qtyUpdate(id) {
                var qty = document.getElementById('qty-'+ id).value;
                axios.post('/qty-update/' + id + '/' + qty)
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllCarts();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            priceUpdate(id) {
                var pricedata = document.getElementById('price-'+ id).value;
                axios.post('/cartPrice/' + id, { price: pricedata })
                    .then(response => {
                        this.AllCarts();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            getCustomerID() {
                let customerID = document.getElementById('customer_id').value;
                return customerID;
            },
            addCustomer() {
                document.getElementById('customer-section').innerHTML = `<input type='hidden' name='customer_id' value="${this.getCustomerID()}">`;
                axios.get('/getCustomer/' + this.getCustomerID())
                    .then(data => {
                        this.customer = data.data
                    })
                    .catch()
            },
            customerRemove() {
                this.customer = '';
            }
        },
        mounted() {
            this.AllCarts();
        }
    });
}
