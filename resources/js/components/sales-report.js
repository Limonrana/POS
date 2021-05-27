if (document.querySelector('.sales-report')) {
    let productForm = new Vue({
        el: ".sales-report",
        delimiters: ['${', '}'],

        data() {
            return {
                sales: [],
            }
        },

        computed: {
            total() {
                let getTotal = this.sales.reduce((sum, item) => sum += parseFloat(item.total), 0);
                return getTotal;
            },
            taxTotal() {
                let getTotal = this.sales.reduce((sum, item) => sum += parseFloat(item.tax), 0);
                return getTotal;
            },
            freightTotal() {
                let getTotal = this.sales.reduce((sum, item) => sum += parseFloat(item.freight_cost), 0);
                return getTotal;
            },
            subTotal() {
                let getTotal = this.sales.reduce((sum, item) => sum += parseFloat(item.subtotal), 0);
                return getTotal;
            },
        },
        created() {

        },

        methods: {
            getSales() {
                let start = document.querySelector('#start_date').value;
                let end = document.querySelector('#end_date').value;
                axios.get('/sales-report/' + start + '/' + end)
                    .then(response => {
                        this.sales = response.data;
                    })
            },
            showSearch() {
                this.sales = [];
            }
        }
    });
}
