<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background: url('./img/user-back.png') center center;">
                        <h3 class="widget-user-username">{{form.name}}</h3>
                        <h5 class="widget-user-desc">{{form.type}}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" src="" alt="User Avatar">
                    </div>
                    </div>
                    <!-- User detail content starts here -->
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active show" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                            <div class="tab-pane active show" id="activity">
                                
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" id="inputName" 
                                    v-model="form.name" :class="{'is-invalid' : form.errors.has('name')}">
                                    <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" id="inputEmail" 
                                    v-model="form.email" :class="{'is-invalid' : form.errors.has('email')}">
                                    <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                    <input type="password" name="Password" class="form-control" id="inputPassword" 
                                    v-model="form.password" :class="{'is-invalid' : form.errors.has('email')}" placeholder="leave empty if not changing">
                                    <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputProfilePicture" class="col-sm-2 control-label">Profile Picture</label>

                                    <div class="col-sm-10">
                                    <input type="file" @change="updateImage" class="form-control" id="inputProfilePicture" placeholder="file" enctype="multipart/form-data">
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <button @click.prevent="update" type="submit" class="btn btn-danger">Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                id : '',
                name : '',
                email : '',
                password : '',
                type : '',
                status : '',
                image: ''
                })
            }
        },
        created() {
            this.form.get('api/profile').then(({ data })=>{
                this.form.fill(data)
            }).catch(()=>{

            })
        },
        methods: {
            update(){
                this.$Progress.start();
                this.form.put('api/profile/')
                    .then(({ data }) => {
                        toast({
                            type: 'success',
                            title: 'User updated successfully'
                            });
                        this.$Progress.finish();
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
            updateImage(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                //Check file size is greater than 2MB
                console.log(file)
                if(file['size'] < 2111775){
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
