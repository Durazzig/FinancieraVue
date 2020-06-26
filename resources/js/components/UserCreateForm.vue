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
          <v-icon>mdi-account-plus-outline</v-icon>
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline"><strong>Crear Usuario</strong></span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" sm="6" md="12">
                <v-text-field v-model="cliente.nombre" label="Nombre" type="text" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="cliente.celular" label="Telefono" type="text" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="cliente.direccion" label="Direccion" type="text" required></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Cerrar</v-btn>
          <v-btn color="blue darken-1" text @click="addClients()">Crear Cliente</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
    export default {
       name: 'UserCreateForm',
       data ()  {
           return {
                dialog: false,
                cliente: {
                    nombre: '',
                    celular: '',
                    direccion: '',
                },
                updated: false,
           }
       },
       methods: {
            addClients(){
                axios.post('api/clients/save',{
                    'nombre': this.cliente.nombre,
                    'celular': this.cliente.celular,
                    'direccion': this.cliente.direccion,
                })
                .then(response => {
                    this.dialog = false;
                    this.updateClientsTable()
                })
            },
            updateClientsTable(){
                this.updated = true
                this.$emit('updated',this.updated)
            }
        },
    }
</script>