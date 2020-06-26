<template>
    <v-dialog v-model="open" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Editar Usuario</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field v-model="value.name" label="Nombre" type="text" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="value.phone" label="Telefono" type="text" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="value.address" label="Direccion" type="text" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="disableEdit">Close</v-btn>
          <v-btn color="blue darken-1" text @click="updateClient()">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</template>
<script>
    export default {
       name: 'UserEditForm',
       data ()  {
           return {
                dialog: false,
           }
       },
       props: {
          open:{
            type: Boolean,
            default: false,
         },
         value:{
           type: Object,
           default: function(){
             return{
                  id: '',
                  name: '',
                  phone: '',
                  address: '',
             }
           },
         },
       },
       watch:{
          open(){
            this.dialog = this.open
          }
       },
       methods: {
            updateClient(){
                axios.post('api/clients/update/' + this.value.id, this.value)
                .then(response => {
                    this.updateClientsTable()
                    this.dialog = false;
                    this.disableEdit()
                })
            },
            updateClientsTable(){
                this.updated = true
                this.$emit('updated',this.updated)
            },
            disableEdit(){
              this.dialog = false
              this.$emit('disable', this.dialog)
            }
        },
    }
</script>