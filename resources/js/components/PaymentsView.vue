<template>
   <v-card>
        <v-data-table
            :headers="headers"
            :items="payments"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Pagos y abonos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn
                    color="success"
                    class="mr-4"
                    @click="abonar"
                    >
                    Abonar
                    </v-btn>
                    <v-text-field
                    v-model="pago.abono"
                    type="number"
                    label="Abono"
                    required
                    ></v-text-field>
                </v-toolbar>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>

export default {
    name:'PaymentsView',
    mounted(){
        let id = this.$route.params.id
        this.getPayments()
    },
    data:()=>{
        return{
             headers:[
                    { text: '#', value: 'no_pago' },
                    { text: 'Cantidad', value: 'cantidad' },
                    { text: 'Fecha de pago', value: 'pago_date' },
                    { text: 'Pago registrado', value: 'pago_registrado' },
                    { text: 'Pagado', value: 'pagado' },
                    { text: 'Actualizacion de pago', value: 'updated_at' },
                ],
            payments:[],
            pago:{
                abono:0,
            },
        }
    },
    methods:{
        getPayments(){
            let id = this.$route.params.id
            axios.get('/api/payments/list/'+id)
                 .then(response=>{
                        //console.log(response.data)
                        this.payments = response.data
                    })
                    .catch(error=>{

                        console.log(error)
                    })
        },
        abonar(){
            let id = this.$route.params.id
            console.log(this.abono)
            axios.put('/api/payments/pay/'+id, this.pago)
                .then(response=>{
                    this.getPayments()
                    alert("Pagado")
                })
                .catch(error=>{
                    console.log(error)
                })
        }
    }
}
</script>