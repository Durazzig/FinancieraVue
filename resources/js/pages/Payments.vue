<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="payments"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Pagos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                </v-toolbar>
            </template>
            <template>
               <PaymetsForm
                v-on:updTable="actualizarTable($event)">
               </PaymetsForm>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn color="blue" x-small dark :to="{ name:'PaymentsView', params:{id:item.id}}">
                    Ver
                </v-btn>
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.client.name }}
            </template>
        </v-data-table>
    </v-card>
</template>
<script>
    import PaymentsView from '@/js/components/PaymentsView';
    export default {
        name: 'Payments',
        components:{
            PaymentsView
        },
        created: function(){
            this.getpayments()
        },
        data: () => {
            return {
                headers:[
                    { text: '#', value: 'id' },
                    { text: 'Cliente', value: 'name' },
                    { text: 'Cantidad', value: 'cantidad' },
                    { text: 'No Pagos', value: 'no_pagos' },
                    { text: 'Cuota', value: 'cuota' },
                    { text: 'Fecha Ministracion', value: 'fecha_ministracion' },
                    { text: 'Fecha Vencimiento', value: 'fecha_vencimiento' },
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                payments: []
            }  
        },
        methods: {
            getpayments(){
                axios.get('api/payments')
                .then(response=>(
                    this.payments = response.data
                ))
            }
        },
    }
</script>