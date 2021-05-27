if (document.querySelector('.purchase-edit')) {
    let productForm = new Vue({
        el: ".purchase-edit",
        delimiters: ['${', '}'],

        data() {
            return {
                purchase: [],
                vendor: [],
                products:[],
                vendorId: '',
                button: false
            }
        },

        computed: {

        },
        created() {
            this.Purchase();
            this.addVendor();
            this.AllProduct();
        },

        methods: {
            buttonAdd() {
                this.button = true;
            },
            cancel() {
                this.button = false;
            },
            Purchase() {
                var id = document.getElementById('purchase_id').value;
                axios.get('/purchase/' + id)
                    .then(data => {
                        this.purchase = data.data
                    })
                    .catch()
            },
            AllProduct() {
                var id = document.getElementById('purchase_id').value;
                axios.get('/purchase-product/' + id)
                    .then(data => {
                        this.products = data.data
                    })
                    .catch()
            },
            increment(id) {
                axios.post('/product-qty/' + id, { type: 'increment' })
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllProduct();
                        this.Purchase();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            decrement(id) {
                axios.post('/product-qty/' + id, { type: 'decrement' })
                    .then(response => {
                        this.AllProduct();
                        this.Purchase();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            qtyUpdate(id) {
                var qty = document.getElementById('qty-'+ id).value;
                axios.post('/product-qty-update/' + id + '/' + qty)
                    .then(response => {
                        if (response.data == "stock-out") {
                            toastr.warning("Opps! Stock Limit Out.");
                        }
                        this.AllProduct();
                        this.Purchase();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            priceUpdate(id) {
                let pricedata = document.getElementById('price-'+ id).value;

                axios.post('/product-price/' + id, { price: pricedata })
                    .then(response => {
                        this.AllProduct();
                        this.Purchase();
                    })
                    .catch(error => {
                        toastr.warning("Opps! Something is wrong.");
                    })
            },
            addVendor() {
                var vendorId = document.getElementById('get_vendor').value;
                axios.get('/getVendor/' + vendorId)
                    .then(data => {
                        this.vendor = data.data
                    })
                    .catch()
            },
            getVendorIDEdit() {
                let vendorID = document.getElementById('vendor_id').value;
                return vendorID;
            },
            addVendorEdit() {
                axios.get('/getVendor/' + this.getVendorIDEdit())
                    .then(data => {
                        this.vendor = data.data
                    })
                    .catch()
            },
            vendorRemove() {
                this.vendor = [];
            }
        }
    });
}
