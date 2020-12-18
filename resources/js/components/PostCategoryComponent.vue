<template> 
    <div>
        <h1>{{ category.title}}</h1>
        <post-list-default 
            :key="currentPage"
            @getCurrentPage="getCurrentPage"
            v-if="total > 0" 
            :posts="posts" 
            :total="total"
            :pCurrentPage="currentPage">
        </post-list-default>   
        <router-link to="/categories"  class="btn btn-primary my-3">Ver categorias</router-link>     
    </div>   
</template>
<script>
export default {
    created(){
        this.getPost();
    },
    methods: {
        postClick: function(p){
            this.postSelected = p;
        },
        getPost(){
            fetch('/api/post/' + this.$route.params.category_id + '/category?page=' + this.currentPage)
                .then(response => response.json())
                .then(json => {
                    this.posts = json.data.posts.data;
                    this.category = json.data.category;
                    this.total = json.data.posts.last_page;
                });
        },
        closeModalPost: function(){
            this.postSelected = '';
        },
        getCurrentPage:function(val){
            this.currentPage = val;
            this.getPost();
        }
    },
    data: function () {
        return {
            postSelected: '',
            posts: [],
            category: "",
            total:0,
            currentPage: 1
        }
    }
    
}
</script>