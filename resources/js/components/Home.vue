<template>

  <v-card
    class="mx-auto"
    max-width="344"
  >
    <v-card-text>
      <p class="display-1 text--primary">
        No. de clientes:
      </p>
      <v-text-field
      v-model="nocliente"
      disabled
      outlined
       prepend-icon="mdi-account-group"
      label="Cantidad"
      ></v-text-field>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
    name:'Home',
    mounted: function(){
        this.getNumberClients()
    },
    data: () => ({
        nocliente:''
    }),
    methods:{
        getNumberClients(){
            axios.get('api/home')
                .then(response=>{
                    this.nocliente= response.data
                    console.log(response.data)
                })
                .catch(error=>{
                    console.log(error)
                })
        }
    }
}
</script>

