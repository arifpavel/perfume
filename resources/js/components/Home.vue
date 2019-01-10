<template>
    <div class="mt-5">
        <div>
        <multiselect  v-model="value" :options="options" :custom-label="nameWithLang" placeholder="Search Your Favourite Perfume..." label="name" track-by="name"></multiselect>
        </div>
        <div v-show="isSelected" class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4 green">RECOMMENDATIONS</h1>
                <h4>BASED ON</h4>
                <h3 class="red"> <b>{{value.name}}</b></h3>
                <p class="lead">We recommend trying these fragrances as they’re the most similar in style, scent and fragrance family.</p>
            </div>
        </div>
        <div class="card-deck mt-5">
            <div class="col-md-4 col-xs-12" v-for="perfume in perfumes.data" :key="perfume.id">
                <div class="card">
                    <img class="card-img-top" :src="getImage(perfume.id)" alt="Card image cap" style="height:300px; width:auto;">
                    <div class="card-body">
                        <h5 class="card-title">{{perfume.name}}</h5>
                        <h6 class="card-text">{{perfume.type}}</h6>
                        <p class="card-text">{{perfume.aroma}}</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">In Stock: {{perfume.stock}}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <pagination :data="perfumes" @pagination-change-page="getResults"></pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                perfumes: [],
                value: {'name' : 'Search Perfume','id' : ''},
                options: [],
                searchid: '',
                isSelected: false
            }
        },
        methods: {
            getImage(ID) {
                let item = this.perfumes.data.find(item => item.id === ID)
                return 'img/perfume/' + item.image
            },
            getResults(page = 1) {
                axios.get('api/perfume?page=' + page)
                    .then((data) => {
                        this.perfumes = data.data
                    })
                    .catch(() => {
                        console.log('Error!')
                    })
            },
            nameWithLang ({ name, id }) {
            return `${name}`
            }
        },
        created() {
            axios.get('api/perfume')
                .then((data) => {
                    this.perfumes = data.data
                    console.log(this.perfumes)
                })
                .catch(() => {
                    console.log('No data here')
                })
            //Getting all perfume name for vue-multiselect
            axios.get('api/getAllName')
            .then( (data) => {
                this.options = data.data
                console.log(data)
            })
            .catch( () => {
                console.log('error occured')
            })
            //Listening searchPerfume event for frontend search
            Fire.$on('searchingPerfume', () => {
                let search = this.$parent.perfumeKey
                console.log(search)
                axios.get('api/searchPerfume?q=' + search)
                    .then((data) => {
                        this.perfumes = parseArray(data.data)
                    })
                    .catch(() => {
                        console.log('something is wrong!')
                    })
            })
        },
        watch: {
            value(newValues){
                this.searchid = newValues.id
                 axios.get('api/search?q='+this.searchid)
                    .then( (data) => {
                        this.perfumes = data.data
                        this.isSelected = true
                        //console.log(data)
                    })
                    .catch( () => {
                        console.log('there is some error')
                    })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }

</script>
