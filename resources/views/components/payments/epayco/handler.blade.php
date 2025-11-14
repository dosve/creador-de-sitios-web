@props([
    'publicKey' => '',
    'privateKey' => '',
    'customerId' => ''
])

<script>
(function () {
    window.PaymentHandlers = window.PaymentHandlers || {};

    const epaycoConfig = {
        publicKey: "{{ addslashes($publicKey) }}",
        privateKey: "{{ addslashes($privateKey) }}",
        customerId: "{{ addslashes($customerId) }}"
    };

    window.PaymentHandlers.epayco = {
        checkout(payload) {
            const { cart, totals, customer } = payload || {};

            if (!cart || cart.length === 0) {
                alert('El carrito está vacío.');
                return;
            }

            if (!epaycoConfig.publicKey || !epaycoConfig.privateKey) {
                alert('La pasarela de pago no está configurada.');
                return;
            }

            if (typeof ePayco === 'undefined') {
                alert('El SDK de Epayco no se ha cargado.');
                return;
            }

            const invoiceNumber = `INV-${Date.now()}`;
            const responseUrl = window.location.origin + '/payment/response';
            const confirmationUrl = window.location.origin + '/payment/confirmation';

            const epaycoData = {
                name: 'Compra en la tienda',
                description: `Pedido de ${cart.length} productos`,
                invoice: invoiceNumber,
                currency: 'COP',
                amount: (totals?.gross ?? 0).toFixed(2),
                tax_base: (totals?.taxBase ?? 0).toFixed(2),
                tax: (totals?.tax ?? 0).toFixed(2),
                tax_ico: (totals?.taxIco ?? 0).toFixed(2),
                country: 'CO',
                lang: 'es',
                external: 'false',
                response: responseUrl,
                confirmation: confirmationUrl,
                name_billing: customer?.name || 'Cliente',
                address_billing: customer?.address || 'Sin dirección',
                type_doc_billing: 'cc',
                mobilephone_billing: customer?.phone || '3000000000',
                number_doc_billing: customer?.document || '1234567890',
                email_billing: customer?.email || 'cliente@email.com',
                extra1: customer?.notes || ''
            };

            try {
                const handler = ePayco.checkout.configure({
                    key: epaycoConfig.publicKey,
                    test: true,
                    autoclick: false
                });

                handler.open(epaycoData);
            } catch (error) {
                console.error('Error al abrir el modal de Epayco:', error);
                alert('No fue posible iniciar el pago. Intenta nuevamente.');
            }
        }
    };
})();
</script>

