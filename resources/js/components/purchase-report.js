if (document.querySelector('.purchase-report')) {
    let productForm = new Vue({
        el: ".purchase-report",
        delimiters: ['${', '}'],

        data() {
            return {
                purchase: [],
                purchaseData: false
            }
        },

        computed: {
            total() {
                let getTotal = this.purchase.reduce((sum, item) => sum += parseFloat(item.total), 0);
                return getTotal;
            },
            taxTotal() {
                let getTotal = this.purchase.reduce((sum, item) => sum += parseFloat(item.tax), 0);
                return getTotal;
            },
            freightTotal() {
                let getTotal = this.purchase.reduce((sum, item) => sum += parseFloat(item.freight_cost), 0);
                return getTotal;
            },
            subTotal() {
                let getTotal = this.purchase.reduce((sum, item) => sum += parseFloat(item.subtotal), 0);
                return getTotal;
            },
        },
        created() {

        },

        methods: {
            getSales() {
                let start = document.querySelector('#start_date').value;
                let end = document.querySelector('#end_date').value;
                axios.get('/purchase-report/' + start + '/' + end)
                    .then(response => {
                        this.purchase = response.data;
                        this.purchaseData = true;
                    })
            },
            showSearch() {
                this.purchase = [];
                this.purchaseData = false;
            }
        }
    });
}
