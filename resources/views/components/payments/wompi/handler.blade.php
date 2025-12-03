@props([
    'publicKey' => '',
    'privateKey' => '',
    'integrityKey' => ''
])

<!-- SDK de Wompi -->
<script src="https://checkout.wompi.co/widget.js"></script>

<script>
(function () {
    window.PaymentHandlers = window.PaymentHandlers || {};

    const wompiConfig = {
        publicKey: "{{ addslashes($publicKey) }}",
        privateKey: "{{ addslashes($privateKey) }}",
        integrityKey: "{{ addslashes($integrityKey) }}"
    };

    console.log('🟣 Wompi Handler inicializado', {
        hasPublicKey: !!wompiConfig.publicKey,
        hasIntegrityKey: !!wompiConfig.integrityKey
    });

    window.PaymentHandlers.wompi = {
        checkout(payload) {
            const { cart, totals, customer } = payload || {};

            console.log('💜 Iniciando checkout de Wompi', {
                cartItems: cart?.length,
                total: totals?.gross,
                customer: customer?.email
            });

            if (!cart || cart.length === 0) {
                alert('El carrito está vacío.');
                return;
            }

            if (!wompiConfig.publicKey) {
                alert('La pasarela de pago Wompi no está configurada. Por favor contacta al administrador.');
                return;
            }

            if (typeof WidgetCheckout === 'undefined') {
                console.error('❌ SDK de Wompi no cargado');
                alert('Error al cargar el sistema de pagos. Por favor recarga la página.');
                return;
            }

            try {
                // Generar referencia única para la transacción
                const reference = `WOM-${Date.now()}-${Math.random().toString(36).substring(7)}`;
                
                // Calcular el monto en centavos (Wompi trabaja con centavos)
                const amountInCents = Math.round((totals?.gross ?? 0) * 100);
                
                // URL de redirección
                const redirectUrl = window.location.origin + '/payment/wompi/response';

                console.log('💳 Datos de pago Wompi:', {
                    reference,
                    amountInCents,
                    currency: 'COP',
                    publicKey: wompiConfig.publicKey.substring(0, 20) + '...'
                });

                // Configurar el checkout de Wompi
                const checkout = new WidgetCheckout({
                    currency: 'COP',
                    amountInCents: amountInCents,
                    reference: reference,
                    publicKey: wompiConfig.publicKey,
                    redirectUrl: redirectUrl,
                    taxInCents: {
                        vat: Math.round((totals?.tax ?? 0) * 100),  // IVA
                        consumption: 0  // Impuesto al consumo
                    },
                    customerData: {
                        email: customer?.email || 'cliente@email.com',
                        fullName: customer?.name || 'Cliente',
                        phoneNumber: customer?.phone || '3000000000',
                        phoneNumberPrefix: '+57',
                        legalId: customer?.document || '1234567890',
                        legalIdType: 'CC'  // CC, CE, NIT, etc.
                    },
                    shippingAddress: {
                        addressLine1: customer?.address || 'Sin dirección',
                        city: customer?.city || 'Bogotá',
                        phoneNumber: customer?.phone || '3000000000',
                        region: customer?.state || 'Cundinamarca',
                        country: 'CO'
                    }
                });

                // Abrir el widget de Wompi
                checkout.open(function (result) {
                    console.log('💜 Resultado de Wompi:', result);
                    
                    // El resultado contiene información sobre la transacción
                    if (result.transaction) {
                        const transaction = result.transaction;
                        
                        console.log('✅ Transacción procesada', {
                            id: transaction.id,
                            status: transaction.status,
                            reference: transaction.reference
                        });

                        // Redirigir a página de confirmación
                        window.location.href = redirectUrl + '?ref=' + reference + '&id=' + transaction.id;
                    }
                });

                console.log('✅ Widget de Wompi abierto');

            } catch (error) {
                console.error('❌ Error al abrir el checkout de Wompi:', error);
                alert('No fue posible iniciar el pago. Por favor intenta nuevamente.');
            }
        },

        /**
         * Verificar el estado de una transacción
         */
        async checkTransactionStatus(transactionId) {
            try {
                // En producción, esto debería llamar a tu backend
                // que a su vez consulta la API de Wompi con la private key
                const response = await fetch(`/api/wompi/transaction/${transactionId}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error verificando transacción de Wompi:', error);
                return null;
            }
        }
    };

    console.log('✅ Wompi Payment Handler registrado');
})();
</script>

