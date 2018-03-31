require([
    'jquery',
    'Absoft_WallCatalog/js/vue',
    'Absoft_WallCatalog/js/axios',
    'Absoft_WallCatalog/js/app',
    'Absoft_WallCatalog/js/vee',
    'Magento_Customer/js/customer-data'
], function ($, Vue, axios, app, vee, customerData) {
    var sections = ['cart']
    Vue.use(vee)
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            product: null,
            loadding: false,
            base64:null

        },
        methods: {
            onSubmit: function () {
                var elements = this.$refs.cartForm.elements;
                var qty = null;
                var options = [].reduce.call(elements, function (data, element, index) {
                    if (element.name !="" && element.name !== 'qty') {
                        data[index] = {
                            optionId: element.name,
                            optionValue: element.value
                        }
                    }
                    if (element.name == 'qty') {
                        console.log(element.value)
                        qty = element.value
                    }

                    return data
                }, []);
                console.log(qty);
                var self = this;
                var quoteMask = $('#quoteIdMask').val();
                var sku = $('#product_sku').val();
                console.log("quoteMask:", quoteMask)
                console.log("sku:", sku)
                console.log("options:", options);
                this.$validator.validateAll().then(function (data) {
                    if (data > 0) {
                        self.loadding = true;
                        axios.post('/rest/V1/guest-carts/' + quoteMask + '/items', {
                                "cart_item": {
                                    "quote_id": quoteMask,
                                    "sku": sku,
                                    "qty": qty ? qty : 1,
                                    "productOption": {
                                        "extensionAttributes": {
                                            "customOptions": options
                                        }
                                    },
                                    'extensionAttributes':{
                                        "imagePreview":"1231231312312312123123131"
                                    }
                                }
                            },
                            {
                                headers: {
                                    Authorization: 'Bearer tnj7wjbteoixx9bikhnshedyg5gpsna7'
                                }
                            })
                            .then(function (response) {
                                self.loadding = false;
                                customerData.invalidate(sections);
                                customerData.reload(sections, true);
                                // location.href = '/checkout/cart'
                            })
                            .catch(function (error) {
                                console.log(error)
                            });
                    }
                }).catch(function () {
                    return false
                });

            },
            check: function (form) {
                // console.log(form.elements)

            },
            sendBase64:function(){
                var self = this;
                console.log(self.base64)
                var form_data = new FormData();
                form_data.append('base64',self.base64)

                axios.post('/rest/V1/upload/image',{base64:self.base64},
                    {
                        headers: {
                            Authorization: 'Bearer tnj7wjbteoixx9bikhnshedyg5gpsna7'
                        }
                    })
            }
        },
        created: function () {
            // const self = this
            // var sku = $('#product_sku').val()
            // axios.get('/rest/V1/products/'+sku,{
            //     headers: {
            //         Authorization: 'Bearer tnj7wjbteoixx9bikhnshedyg5gpsna7'
            //     }
            // })
            // .then(function (response) {
            //     self.loadding = false
            //     self.product = response.data
            // })
            // .catch(function (error) {
            //     console.log(error)
            // });

        }
    })
    // var a =  require('Absoft_WallCatalog/js/app')
    // console.log(a);
});
