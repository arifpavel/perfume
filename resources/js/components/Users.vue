<template>
    <div class="container">
        <div class="row">
          <div class="col-md-12 mt-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="addUserModal()">
                      <i class="fa fa-user-plus fa-fw"></i>Add New</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr class="thead">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Joined At</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{user.id}}</td>
                    <td>{{user.name | capitalize}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | capitalize}}</td>
                    <td><span class="tag tag-success">{{user.status | capitalize}}</span></td>
                    <td>{{user.created_at | dateformet}}</td>
                    <td>
                        <a href="#" @click="editUserModal(user)" v-if="$gate.isSuperAdmin()"><i class="fa fa-edit orange fa-fw"></i></a>
                        <a href="#" @click="deleteuser(user.id)"><i class="fa fa-trash red"></i></a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="users" @pagination-change-page="getResults"></pagination>
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
                <h5 v-show="!editmode" class="modal-title" id="exampleModalLongTitle">Add New User</h5>
                <h5 v-show="editmode" class="modal-title" id="exampleModalLongTitle">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                    <input v-model="form.name" placeholder="Name of User" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.email" placeholder="Email" type="text" name="email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                    <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                    <input v-model="form.password" placeholder="Password" type="password" name="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                    <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                    <select name="type" v-model="form.type" class="form-control" :class="{
                        'is-invalid' : form.errors.has('type')
                    }">
                        <option value="">Select User Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                    </div>
                    <div class="form-group">
                    <select name="status" v-model="form.status" class="form-control" :class="{
                        'is-invalid' : form.errors.has('status')
                    }">
                        <option value="">Select User Status</option>
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                    </select>
                    <has-error :form="form" field="status"></has-error>
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
            users: [],
            form: new Form({
                id : '',
                name : '',
                email : '',
                password : '',
                type : '',
                status : ''
            }),
            }
        },
        methods: {
            addUserModal(){
                this.editmode = false
                this.form.reset();
                $('#addNewUser').modal('show');
            },
            editUserModal(user){
                this.editmode = true
                this.form.reset();
                this.form.fill(user);
                $('#addNewUser').modal('show');
            },
            getUsers(){
                axios.get('api/user').then(({data}) =>
                {
                    this.users = data
                    console.log(this.users)
                })
            },
            addUser(){
                this.$Progress.start();
                // Submit the form via a POST request
                this.form.post('api/user')
                    .then(({ data }) => {
                        $('#addNewUser').modal('hide');
                        toast({
                            type: 'success',
                            title: 'User created successfully'
                            });
                        this.$Progress.finish();
                        Fire.$emit('usercreated'); 
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
                this.form.put('api/user/'+this.form.id)
                    .then(({ data }) => {
                        $('#addNewUser').modal('hide');
                        toast({
                            type: 'success',
                            title: 'User updated successfully'
                            });
                        this.$Progress.finish();
                        Fire.$emit('usercreated'); 
                        })
                    .catch(({error}) => {
                        toast({
                            type: 'error',
                            title: 'There is some error!'
                            });
                        this.$Progress.fail();
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
                this.form.delete('api/user/'+id).then(()=>{
                    Swal(
                    'Deleted!',
                    'User has been deleted.',
                    'success'
                    )
                    Fire.$emit('usercreated')
                }).catch(()=>{
                    Swal("Failed","There was something wrong","warning")
                })
                }
                })
                console.log(id);
            },
            getResults(page = 1){
                axios.get('api/user?page=' + page)
                .then(response => {
                    this.users = response.data
                })
            }
        },
        created(){
            this.getUsers()
            Fire.$on('searching', () => {
                let search = this.$parent.searchkey
                let vthis = this
                axios.get('api/searchUser?q='+search)
                .then((data)=> {
                    vthis.users = data.data
                    console.log(data.data)
                })
                .catch((error) => {
                    console.log('there are some error!')
                })
                //console.log(search)
            })
            Fire.$on('usercreated',() => { 
                this.getUsers()
            })
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
