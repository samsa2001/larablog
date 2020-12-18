<template> 
    <div>
        <div v-if="post">
            <div class="card">
                <img class="card-header" v-bind:src="'/images/'+ post.image.image" v-bind:alt="post.image.image">
                <div class="card-body">
                    <router-link :to="{name:'post-category',params:{category_id: post.category.id}}" class="btn btn-success">{{post.category.title}}</router-link>
                    <h1 class="card-title">{{post.title}}</h1>
                    <p class="card-text">{{post.content}}</p>
                </div>
            </div>
        </div>
        <div v-else>
            <h1>El post no existe</h1>
        </div>
    </div>   
</template>
<script>
export default {
    created(){
        this.getPost();
        console.log("Método detalle creado");
    },
    methods: {
        getPost(){
            fetch('/api/post/' + this.$route.params.id)
                .then(response => response.json())
                .then(json => this.post = json.data);
        },
    },
    data: function () {
        return {
            postSelected: '',
            post: ''
        }
    }
    
}
</script>