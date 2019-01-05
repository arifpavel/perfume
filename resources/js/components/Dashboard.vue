<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-12">
                <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fa fa-search fa-2x"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Search</span>
                    <span class="info-box-number">41,410</span>

                    <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                    2 Searches failed to get a perfume today
                    </span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
          </div>
          <div class="col-md-6 col-12">
                <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-wine-bottle fa-2x"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number">3,410</span>

                    <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                    </div>
                    <span class="progress-description">
                    Perfumed registered in the system so far
                    </span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
