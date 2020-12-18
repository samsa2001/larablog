<template> 
<div>
    <div>
        <!-- :key es una variable de vue a la cual podemos asociar una variable de nuestro sistema. cada vez que la variable asignada a key cambie el componente se redibujará -->
        <!-- @getCurrentPage escucha la emisión de un evento @getCurrentPage y ejecuta el método con ese nombre -->
         <post-list-default 
            :key="currentPage"
            @getCurrentPage="getCurrentPage"
            v-if="total > 0" 
            :posts="posts" 
            :total="total"
            :pCurrentPage="currentPage">
        </post-list-default>
    </div>  
</div>
</template>
<script>
export default {
    created(){
        this.getPosts();
    },
    methods: {
        postClick: function(p){
            this.postSelected = p;
        },
        getPosts(){
            console.log('/api/post?page=' + this.currentPage);
            fetch('/api/post?page=' + this.currentPage)
                .then(response => response.json())
                .then(json => {
                    this.posts = json.data.data;
                    this.total = json.data.last_page;
                });
/*                 .then(function(response){
                    return response.json();
                })
                .then(function(json){
                    console.log(json.data.data[0].title);
                }) */
        },
        getCurrentPage: function(val){
            this.currentPage = val;
            this.getPosts();
        }
    },
    data: function () {
        return {
            postSelected: '',
            posts: [],
            total:0,
            currentPage: 1
        }
    }
    
}
</script>