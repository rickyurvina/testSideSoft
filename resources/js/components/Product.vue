<template>
    <div>
        <h1 class="text-center">Gestionar Productos</h1>
        <hr>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary">
            Nuevo producto
        </button>

        <!-- Modal -->
        <div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Descripcción</th>
                <th scope="col">Foto</th>
                <th scope="col" colspan="2" class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="pro in products" :key="pro.id">
                <th scope="row">{{pro.id}}</th>
                <td>{{pro.code}}</td>
                <td>{{pro.name}}</td>
                <td>{{pro.description}}</td>
                <td>{{pro.photo}}</td>
                <td>
                    <button class="btn btn-warning">Editar</button>
                </td>
                <td>
                    <button @click="deleteP(pro.id)" class="btn btn-danger">Eliminar</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>
<script>
export default {
    data(){
        return {
            products:[],

        }
    },
    methods:{
        async list(){
            const res= await axios.get('/api/products');
            this.products=res.data;
        },
        async deleteP(id){
            const res= await axios.delete('/api/products/'+id);
            this.list();
        },
    },
    mounted() {
        console.log('Component de ejemplo')
    },
    created(){
        this.list();
    }
}
</script>
<style>

</style>
