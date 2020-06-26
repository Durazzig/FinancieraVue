<template>
    <v-card>
        <v-data-table
            :headers="headers"
            :items="loans"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat color="white">
                    <v-toolbar-title><strong>Prestamos</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn @click="exportar" dark color="blue">Exportar Prestamos</v-btn>
                    <v-spacer></v-spacer>
                   <LoanCreateForm
                       v-on:updTable="actualizarTable($event)">
                   </LoanCreateForm>
                </v-toolbar>
            </template>
            <template v-slot:item.name="{ item }">
                {{ item.client.name }}
            </template>
        </v-data-table>
    </v-card>
</template>
<script>
import LoanCreateForm from '@/js/components/LoanCreateForm';
import XLSX from "xlsx";
    export default {
        name: 'Loans',
         components: {
            LoanCreateForm,
        },
        mounted: function(){
            this.getLoans()
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
                ],
                loans: [],
                table:[ ]
            }  
        },
        methods: {
            getLoans(){
                axios.get('api/loans').then(response=>{
                    this.loans = response.data
                    console.log(response)
                })
                .catch(error=>{
                    console.log(error)
                })
            },
            actualizarTable(event){
                console.log(event)
                if(event)
                {
                    this.getLoans()
                }
            },
            exportar: function()
            {
                const workbook = XLSX.utils.book_new()
                const filename = 'pagos'
                let data = XLSX.utils.json_to_sheet(this.loans)
                XLSX.utils.book_append_sheet(workbook, data, filename)
                XLSX.writeFile(workbook, `${filename}.xlsx`)
            }
        },
    }
</script>
