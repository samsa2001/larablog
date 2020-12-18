<template> 
    <div>
        <div class="row">
            <div v-for="post in posts" :key="post.title" class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{post.title}}</h5>
                        <router-link :to="{name:'post-category',params:{category_id: post.id}}" class="btn btn-success">Ver posts</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>   
</template>
<script>
export default {
    created(){
        this.getPost();
    },
    methods: {
        getPost(){
            fetch('/api/category/all')
                .then(response => response.json())
                .then(json => {
                    console.log(json.data);
                    this.posts = json.data
            });
        }
    },
    data: function () {
        return {
            posts:[]
        }
    }    
}
</script>