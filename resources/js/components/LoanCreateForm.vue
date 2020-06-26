<template>
  <v-row justify="end">
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="primary"
          dark
          v-bind="attrs"
          v-on="on"
        >
          <v-icon>mdi-currency-usd</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Crear Prestamo</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-select
                  v-model="prestamo.client_id"
                  v-bind:items="names"
                  item-text="name"
                  item-value="id"
                  label="Nombre"
              ></v-select>
              </v-col>
              <v-col cols="12">
                <v-text-field 
                 v-model="prestamo.cantidad"
                 label="Monto" 
                 type="number" 
                 required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                 v-model="prestamo.no_pagos" 
                 @change="updateCuotas"
                 label="No. Pagos" 
                 type="number" 
                 required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                 v-model="prestamo.cuota" 
                 label="Cuota" 
                 type="number" 
                 required
                 v-bind:readonly="this.prestamo.cuota">
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                 v-model="prestamo.firstDate" 
                 label="Fecha de ministración" 
                 type="date"
                 @change="updateDate" 
                 required>
                </v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                 v-model="prestamo.lastDate" 
                 label="Fecha de vencimiento" 
                 type="date" 
                 required>
                </v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" text v-on:click="addLoan">Crear Prestamo</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
    var moment = require('moment');
    var moment_business = require('moment-business-days');
    export default {
       name: 'LoanCreateForm',
       mounted: function(){
         this.getNames()
       },
       data: () => ({
           dialog: false,
           prestamo:{
              client_id:'',
              cantidad:'',
              no_pagos:'',
              cuota:'',
              firstDate: '',
              lastDate:''
           },
           update: false,
           names:[],
           select: { state: 'Nombre', abbr: 'id' },
       }),
       methods: {
            addLoan(){
              axios.post('api/loans',this.prestamo)
                .then(response=>{
                  this.actualizarTable()
                  this.dialog = false
                  console.log('guardado')
                })
                .catch (error=>{
                  console.log(error)
                })
            },
            actualizarTable(){
              this.update = true
              this.$emit('updTable',this.update)
            },
            getNames(){
              axios.get('api/loans/names')
                .then(response=>{
                  this.names=response.data
                })
                .catch (error=>{
                  console.log(error)
                })
            },
            updateCuotas(){
                this.prestamo.cuota = this.prestamo.cantidad/this.prestamo.no_pagos
            },
            updateDate(){
                var date = this.prestamo.firstDate
                var realDate = moment(date, 'YYYY-MM-DD').businessAdd(this.prestamo.no_pagos)._d
                this.prestamo.lastDate = moment(realDate, 'YYYY-MM-DD').format('YYYY-MM-DD')
            },
        }
    }
</script>