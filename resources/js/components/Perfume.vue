<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pefumes</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="addUserModal()">
                      <i class="fas fa-wine-bottle fa-fw"></i>Add New</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr class="thead">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Aroma</th>
                    <th>Type</th>
                    <th>In Stock</th>
                    <th>Added At</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="perfume in perfumes.data" :key="perfume.id">
                    <td>{{perfume.id}}</td>
                    <td>{{perfume.name | capitalize}}</td>
                    <td>{{perfume.aroma}}</td>
                    <td>{{perfume.type | capitalize}}</td>
                    <td><span class="tag tag-success">{{perfume.stock}}</span></td>
                    <td>{{perfume.created_at | dateformet}}</td>
                    <td>
                        <a href="#" @click="editUserModal(perfume)" v-if="$gate.isAdmin() || $gate.isSuperAdmin()"><i class="fa fa-edit orange fa-fw"></i></a>
                        <a href="#" @click="deleteuser(perfume.id)"><i class="fa fa-trash red"></i></a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="perfumes" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
        <form @submit.prevent="editmode ? updateUser() : addUser()" @keydown="form.onKeydown($event)">
            <div class="modal-header">
                <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Add New Perfume</h5>
                <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Update Perfume</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="col-md-12">
                        <img v-show="editmode" :src="getImage()" class="img-thumbnail rounded mx-auto d-block"  style="height:100px;width:100px;" alt="">
                    </div>
                    <div class="form-group mt-5">
                    <input v-model="form.name" placeholder="Name of the Perfume" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.aroma" placeholder="Aroma" type="text" name="aroma"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('aroma') }">
                    <has-error :form="form" field="aroma"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.type" placeholder="Type" type="text" name="type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <has-error :form="form" field="type"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.stock" placeholder="stock" type="text" name="stock"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('stock') }">
                    <has-error :form="form" field="stock"></has-error>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                        <input type="file" @change="updateImage" class="form-control" id="inputProfilePicture" placeholder="file" enctype="multipart/form-data">
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="!editmode" :disabled="form.busy" type="submit" class="btn btn-primary">Create</button>
                <button v-show="editmode" :disabled="form.busy" type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
            editmode : false,
            perfumes: [],
            form: new Form({
                id : '',
                name : '',
                aroma : '',
                type : '',
                stock : '',
                image : ''
            }),
            isTempImage: false
            }
        },
        methods: {
            addUserModal(){
                this.editmode = false
                this.form.reset();
                $('#addNewUser').modal('show');
            },
            editUserModal(perfume){
                this.editmode = true
                this.form.reset();
                this.form.fill(perfume);
                $('#addNewUser').modal('show');
            },
            getUsers(){
                axios.get('api/perfume').then(({data}) =>
                {
                    this.perfumes = data
                    console.log(this.perfumes)
                })
            },
            addUser(){
                this.$Progress.start();
                // Submit the form via a POST request
                this.form.post('api/perfume')
                    .then(({ data }) => {
                        $('#addNewUser').modal('hide');
                        toast({
                            type: 'success',
                            title: 'Perfume created successfully'
                            });
                        this.$Progress.finish();
                        Fire.$emit('perfumecreated'); 
                        console.log(data) 
                        })
                    .catch(({error}) => {
                        toast({
                            type: 'error',
                            title: 'There is some error!'
                            });
                        this.$Progress.fail();
                        });
            },
            updateUser(){
                this.$Progress.start();
                console.log(this.form.id)
                //Submit the form via a PUT request
                this.form.put('api/perfume/'+this.form.id)
                    .then(({ data }) => {
                        $('#addNewUser').modal('hide');
                        toast({
                            type: 'success',
                            title: 'Perfume updated successfully'
                            });
                        this.$Progress.finish();
                        Fire.$emit('perfumecreated'); 
                        console.log(data)
                        })
                    .catch(({error}) => {
                        toast({
                            type: 'error',
                            title: 'There is some error!'
                            });
                        this.$Progress.fail();
                        console.log(error)
                        });
            },
            deleteuser(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })
                swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
                }).then((result) => {
                if(result.value){
                this.form.delete('api/perfume/'+id).then(()=>{
                    Swal(
                    'Deleted!',
                    'Perfume has been deleted.',
                    'success'
                    )
                    Fire.$emit('perfumecreated')
                }).catch(()=>{
                    Swal("Failed","There was something wrong","warning")
                })
                }
                })
                console.log(id);
            },
            getResults(page = 1){
                axios.get('api/perfume?page=' + page)
                .then(response => {
                    this.perfumes = response.data
                })
            },
            getImage(){
                if(this.isTempImage){
                    this.isTempImage = false
                    return this.form.image
                }else{
                return 'img/perfume/'+this.form.image
                }
            },
            updateImage(e){
                let file = e.target.files[0];
                console.log('file array'+ e.target.files)
                let reader = new FileReader();
                //Check file size is greater than 2MB
                console.log(file)
                if(file['size'] < 2111775){
                reader.onload = (file) => {
                this.isTempImage = true
                this.form.image = reader.result
                this.getImage()
                }
                reader.onloadend = (file) => {
                    this.form.image = reader.result
                }
                reader.readAsDataURL(file);
                }else{
                   Swal({
                       type: 'error',
                       title: 'Ooops!!',
                       text: 'Your file is larger than 2 MB'
                   })
                }
            }
        },
        created(){
            this.getUsers()
            Fire.$on('searching', () => {
                let search = this.$parent.searchkey
                let vthis = this
                axios.get('api/searchPerfume?q='+search)
                .then((data)=>{
                    vthis.perfumes = data.data
                })
                console.log(search)
            })
            Fire.$on('perfumecreated',() => { 
                this.getUsers()
            })
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
