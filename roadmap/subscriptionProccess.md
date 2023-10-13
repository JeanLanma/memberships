# Pasos para la suscripción de un usuario con cashier

## Resumen proceso de creacion de subscripcion
Pasos que debe seguir el usuario para crear una subscripcion
1. Registre un metodo de pago
2. Seleccione el plan
3. Administre la subscripción

## Log de usuarios caso ideal
En el caso mas ideal el log de usuarios deberia tener los siguientes eventos.    
Orden de los eventos que llegan al log de usuarios por el webhook

1. customer.updated
2. customer.updated
3. customer.subscription.created
4. customer.subscription.updated
5. invoice.payment_succeeded

En el proceso anterior primero se crea el usuario junto al metodo de pago y se asocian
luego se crea la subscripcion y se asocia al usuario y por ultimo se genera la factura

## Eventos que se reciben en el webhook
Posibles eventos de Stripe:
* customer.updated
* customer.deleted
* customer.subscription.created
* customer.subscription.deleted
* customer.subscription.updated
* invoice.payment_action_required
* invoice.payment_succeeded
* payment_method.automatically_updated

## Extraer información del customer del objeto "customer.updated"
```js
// En notación JSON es objeto
`payload.data.object` // Customer: objects
`payload.data.object.id` // Id del usuario: string
```
## Extraer información del plan del objeto "customer.subscription.created"
```js
// En notación JSON es objeto
`payload.data.object.plan` // Plan: object
`payload.data.object.plan.id` // Id del plan: string
```
## Extraer el status y el customer de  del objeto "customer.subscription.updated"

```js
// En notación JSON esta en el objeto
 `payload.data.object.status` // Status: string
 `payload.data.object.customer` // Id del usuario: string
 `payload.data.object.plan` // Plan: object

 // En notación JSON esta en el objeto
 `payload.data.object.cancel_at` // Fecha de cancelacion: timestamp
 // y el valor es un booleano en caso de que sea true significa que se cancelo la subscripcion
 `payload.data.object.cancel_at_period_end`

 `payload.data.object.current_period_start` // Fecha del ciclo de facturacion actual: timestamp
 `payload.data.object.current_period_end` // Proximo ciclo de facturacion: timestamp
```

## Extraer el status del objeto "invoice.payment_succeeded"
```js
// En notación JSON esta en el objeto
 `payload.data.object.status`
```

## Extraer información sobre el objeto "customer.subscription.deleted"
```js
// En notación JSON esta en el objeto
 `payload.data.object.cancel_at` // Fecha de cancelacion: timestamp
 `payload.data.object.cancel_at_period_end` // booleano
 `payload.data.object.status` // Status: string
 `payload.data.object.customer` // Id del usuario: string
```