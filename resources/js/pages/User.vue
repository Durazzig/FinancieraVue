<template>
    <v-card>
        <v-toolbar dark color="blue"><v-card-title><strong>Bienvenido: {{clientes.name}}</strong></v-card-title></v-toolbar>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col>
                        <v-title>Usuario</v-title>
                        <v-text-field v-model="clientes.name"></v-text-field>
                    </v-col>
                    <v-col>
                        <v-title>Correo</v-title>
                        <v-text-field v-model="clientes.email"></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="12">
                        <v-btn @click="postUser">Actualizar</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>
<script>
export default {
    name: 'Users',
    mounted: function(){
        this.getUser()
        this.clientes
    },
    data: () => {
            return {
                clientes: [],
            }  
    },
    methods:{
        getUser(){
                axios.get('api/user')
                .then(response=>{
                    console.log(this.clientes)
                    this.clientes = response.data
                    //console.log(this.clientes)
                })
        },
        postUser(){
                axios.put('api/user',this.clientes)
                .then(response=>{
                    console.log(this.clientes)
                    this.clientes = response.data
                    this.getUser()
                    //console.log(this.clientes)
                })
        },
    }
}
</script>