<template>
    <v-card shaped>
        <v-data-table
            :headers="headers"
            :items="clientes"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar flat dark color="light-blue">
                    <v-toolbar-title><strong>Clientes</strong></v-toolbar-title>
                    <v-divider
                    class="mx-4"
                    inset
                    vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-btn color="blue" @click="importClients">Importar Clientes</v-btn>
                    <input color="blue" type="file" ref="file" v-on:change="handleFileUpload()">
                    <v-spacer></v-spacer>
                    <UserCreateForm v-on:updated="updateTable($event)"></UserCreateForm>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-btn color="blue" dark @click="editItem(item)">
                    <v-icon>mdi-circle-edit-outline</v-icon>
                </v-btn>
                <v-btn color="red" dark @click="deleteClient(item)">
                    <v-icon>mdi-delete-circle-outline</v-icon>
                </v-btn>
            </template>
        </v-data-table>
        <UserEditForm v-model="editedItem" v-on:updated="updateTable($event)" v-on:disable="disableEdit($event)" :open="openModal"></UserEditForm>
    </v-card>
</template>
<script>
    import UserCreateForm from '@/js/components/UserCreateForm';
    import UserEditForm from '@/js/components/UserEditForm';
    export default {
        name: 'Clients',
        components: {
            UserCreateForm,
            UserEditForm,
        },
        mounted: function(){
            this.getClients()
        },
        data: () => {
            return {
                headers:[
                    { text: '#', value: 'id' },
                    { text: 'Nombre', value: 'name' },
                    { text: 'Telefono', value: 'phone' },
                    { text: 'Acciones', value: 'actions', sortable: false },
                ],
                clientes: [],
                editedItem: {
                    id: '',
                    name: '',
                    phone: '',
                    address: '',
                },
                update: false,
                openModal: false,
                file:'',
            }  
        },
        methods: {
            getClients(){
                axios.get('api/clients').then(response=>(
                    this.clientes = response.data
                ))
            },
            updateTable(data){
                if(data==true){
                    this.getClients()
                }
            },
            deleteClient(item){
                if(confirm('Desea eliminar a este cliente?'))
                {
                    const index = this.clientes.indexOf(item)
                    const id = this.clientes[index].id;
                    axios.post('api/clients/delete/'+id)
                    .then(response=>{
                        alert('Cliente eliminado')
                        this.update=true
                        this.updateTable(this.update)
                    })
                    .catch(response=>{
                        alert('El cliente no puede ser eliminado ya que tiene prestamos en su cuenta')
                    })
                }
            },
            editItem(item) {
                this.editedIndex = this.clientes.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.enableEdit()
            },
            enableEdit(){
                this.openModal = true
            },
            disableEdit(data){
                this.openModal = data
            },
            importClients(){
            let formData = new FormData();
            formData.append('file', this.file);
            axios
                .post('/api/clients/import',
                    formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(){
                    console.log('SUCCESS!!');
                })
                .catch(function(){
                    console.log('FAILURE!!');
                });
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            }
        },
    }
</script>
