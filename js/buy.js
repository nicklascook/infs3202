paypal.Button.render({
    env: 'sandbox', // Or 'sandbox',

    client: {
        sandbox: 'ARL9NIgdLK4KJzgjEf1KVnaZ-kYZuQFrJ8Sd1dzurV_nTyMYA6JJbZaGe2wlDjycb07TFSV-oI_ZzLbP',
    },

    commit: true, // Show a 'Pay Now' button

    style: {
        color: 'gold',
        size: 'small'
    },

    payment: function (data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [{
                    amount: {
                        total: '1.00',
                        currency: 'USD'
                    }
                }]
            }
        });
    },

    onAuthorize: function (data, actions) {
        return actions.payment.execute().then(function (payment) {

            
            var data = {
                "itemId": getUrlParam("id")
            };

            $.ajax({
                url: "purchaseHandle.php",
                type: "post",
                data: data,
                success: function (response) {
                    window.location.replace("index.php?itemPurchase=true");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                },
            })

            // The payment is complete!
            // You can now show a confirmation message to the customer
        });
    },

    onCancel: function (data, actions) {
        /* 
         * Buyer cancelled the payment 
         */
    },

    onError: function (err) {
        /* 
         * An error occurred during the transaction 
         */
    }
}, '#paypal-button');