<template> 
    <div>
        <div class="row">
            <div class="col-4 mb-4" v-for="post in posts" :key="post.title">
                <div class="card">
                    <img class="card-img-top" v-bind:src="'/images/'+ post.image" v-bind:alt="post.image">
                    <div class="card-body">
                        <h5 class="card-title">{{post.title}}</h5>
                        <p class="card-text">{{post.content}}</p>
                        <button class="btn btn-primary" v-on:click="postClick(post)">Ver resumen</button>
                        <router-link :to="{name:'detail',params:{id: post.id}}" class="btn btn-success">Ver</router-link>
                    </div>
                </div>
            </div>
        </div> 
        <modal-post @closeModalPost="closeModalPost" :post="postSelected"></modal-post>
        <v-pagination 
            v-model="currentPage"
            :page-count="total"
            :classes="bootstrapPaginationClasses"
            :labels="paginationAnchorTexts"></v-pagination>     
    </div>   
</template>
<script>
import vPagination from 'vue-plain-pagination'
export default {
    props:['posts','total','pCurrentPage'],
    created(){
        this.currentPage = this.pCurrentPage;
    },
    methods: {
        postClick: function(p){
            this.postSelected = p;
        },
        closeModalPost: function(){
            this.postSelected = '';
        }
    },
    data: function () {
        return {
            postSelected: '',
            currentPage: 1,
            bootstrapPaginationClasses: {
                ul: 'pagination',
                li: 'page-item',
                liActive: 'active',
                liDisable: 'disabled',
                button: 'page-link'  
            },
            paginationAnchorTexts: {
                first: 'Primero',
                prev: 'Anterior',
                next: 'Siguiente',
                last: 'Último'
            }
        }
    },
    components: { 
        vPagination 
    },
    watch:{
        // watch vigila un evento y se ejecuta cada vez que cambia el valor
        currentPage: function(newVal,oldVal){
            // $emit propaga una funcion buscando el componente que la tiene declarada y ejecutandola
            this.$emit('getCurrentPage',newVal)
        }
    }
    
}
</script>