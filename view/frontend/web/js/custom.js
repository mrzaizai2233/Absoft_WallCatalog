require([
    'jquery',
    'Absoft_WallCatalog/js/vue',
    'Absoft_WallCatalog/js/axios',
    'Absoft_WallCatalog/js/app'
], function ($,Vue,axios,app) {
    var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            product:null,
            loadding:false,

        },
        methods:{
            onSubmit:function(){
                var elements = this.$refs.cartForm.elements;
                var qty = null;
                var options = [].reduce.call(elements,function(data,element,index){
                    if(element.value){
                        data[index]={
                            optionId:element.name,
                            optionValue:element.value
                        }
                    }
                    if(element.name=='qty'){
                        console.log(element.value)
                        qty = element.value
                    }

                    return data
                },[]);
                console.log(qty);
                var self = this;
                var quoteMask  = $('#quoteIdMask').val();
                var sku = $('#product_sku').val();
                console.log("quoteMask:",quoteMask)
                console.log("sku:",sku)
                console.log("options:",options)
                this.loadding= true;
                    axios.post('/rest/V1/guest-carts/'+quoteMask+'/items',{
                        "cart_item":{
                            "quote_id":quoteMask,
                            "sku":sku,
                            "qty":qty?qty:1,
                            "productOption":{
                                "extensionAttributes":{
                                    "customOptions":options
                                }
                            }
                        }
                    },{
                        headers: {
                            Authorization: 'Bearer tnj7wjbteoixx9bikhnshedyg5gpsna7'
                        }
                    })
                        .then(function (response) {
                            location.href = '/checkout'
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
            },
            check:function(form){
                console.log(form.elements)
                // console.log(window.localStorage.getItem('mage-cache-storage'))
            }
        },
        created:function(){
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


});
