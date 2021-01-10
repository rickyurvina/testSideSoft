<template>
    <div>
        <h1 class="text-center">Gestionar Productos</h1>
        <hr>

        <!-- Button trigger modal -->
        <button type="button"  class="btn btn-primary my-4" @click="edit=false; openModal()">
            Nuevo producto
        </button>

        <!-- Modal -->
        <div class="modal fade" :class="{show:modal}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{titleModal}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="code">Código</label>
                            <input type="text" name="code" v-model="product.code" class="form-control" id="code" placeholder="Código del producto">
                            <small class="form-text text-muted">Código debe ser único</small>
                        </div>

                        <div class="form-group">
                            <label for="code">Nombre</label>
                            <input type="text" v-model="product.name" name="name" class="form-control" id="name" placeholder="Nombre del producto">

                        </div>
                        <div class="form-group">
                            <label for="code">Descripcción</label>

                            <textarea class="form-control" v-model="product.description" name="description" id="description" placeholder="Descripcción del producto" rows="3"></textarea>

                        </div>
                        <div class="form-group">
                            <label for="code">Foto</label>
                            <input type="file" class="form-control" @change="savePhoto">
                            <figure>
                                <img with="200" height="200" :src="imagen" alt="Imagen Producto">
                            </figure>
                            <figure>
                                <img width="200" height="200" :src="'http://localhost:8000/'+product.photo">
                            </figure>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal()">Cancelar</button>
                        <button type="button" class="btn btn-success" @click="save()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped">
            <thead class="thead-dark">
            <tr class="text-center">
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
                <!--                <th scope="row">{{pro.id}}</th>-->
                <td>{{pro.code}}</td>
                <td>{{pro.name}}</td>
                <td>{{pro.description}}</td>
                <td><img width="200" height="200" :src="'http://localhost:8000/'+pro.photo"></td>
                <td>
                    <button class="btn btn-warning" @click="edit=true; openModal(pro)">Editar</button>
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
            modal:false,
            titleModal:'',
            products:[],
            edit:true,
            id:0,
            product:{
                code:'',
                name:'',
                description:'',
                photo:'',
            },
            photoMin:'',
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
        async save(id){
            if(this.edit){
                const res=await axios.put('/api/products',this.product);
            }else{
                const res=await axios.post('/api/products', this.product);
            }
            this.list();
            this.closeModal();
        },
        savePhoto(e){
            let file=e.target.files[0];
            console.log(file);
            var fileReader= new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload=(e)=>{
                this.photoMin=e.target.result;
                this.product.photo=e.target.result;
            }
        },

        openModal(data={}){
            this.modal=true;
            if(this.edit){
                this.id=data.id,
                this.titleModal="Modificar Producto";
                this.product.code=data.code;
                this.product.name=data.name;
                this.product.description=data.description;
                this.product.photo=data.photo;
            }else{
                this.id=data.id,
                this.titleModal="Crear Producto";
                this.product.code='';
                this.product.name='';
                this.product.description='';
                this.product.photo='';
            }
        },
        closeModal(){
            this.modal=false;
        },
    },
    computed:{
        imagen(){
            return this.photoMin;
        }
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
.show{
    display:list-item;
    opacity:1;
    background:rgba(44,38,75,0.849);
}
</style>
