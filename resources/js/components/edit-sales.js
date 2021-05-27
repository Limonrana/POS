if (document.querySelector('.sales-edit')) {
    let productForm = new Vue({
        el: ".sales-edit",
        delimiters: ['${', '}'],

        data() {
            return {
                sales: [],
                customer: [],
                products:[],
                customerId: '',
                button: false
            }
        },

        computed: {

        },
        created() {
            this.Sales();
            this.addCustomer();
            this.AllProduct();
        },

        methods: {
            buttonAdd() {
                this.button = true;
            },
            cancel() {
                this.button = false;
            },
            Sales() {
                var id = document.getElementById('sales_id').value;
                axios.get('/sales/' + id)
                    .then(data => {
                        this.sales = data.data
                    })
                    .catch()
            },
            AllProduct() {
                var id = document.getElementById('sales_id').value;
                axios.get('/sales-product/' + id)
                    .then(data => {
                        this.products = data.data
                    })
                    .catch()
            },
            increment(id) {
                axios.post('/sales-product-qty/' + id, { type: 'increment' })
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllProduct();
                        this.Sales();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            decrement(id) {
                axios.post('/sales-product-qty/' + id, { type: 'decrement' })
                    .then(response => {
                        this.AllProduct();
                        this.Sales();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            qtyUpdate(id) {
                var qty = document.getElementById('qty-'+ id).value;
                axios.post('/sales-product-qty-update/' + id + '/' + qty)
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllProduct();
                        this.Sales();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            priceUpdate(id) {
                let pricedata = document.getElementById('price-'+ id).value;

                axios.post('/sales-product-price/' + id, { price: pricedata })
                    .then(response => {
                        this.AllProduct();
                        this.Sales();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            addCustomer() {
                var Id = document.getElementById('customer_id').value;
                axios.get('/getCustomer/' + Id)
                    .then(data => {
                        this.customer = data.data
                    })
                    .catch()
            }
        }
    });
}
