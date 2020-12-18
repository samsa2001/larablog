<template>
  <div class="col-8 offset-2">
    <div class="card">
      <div class="card-header">
        <img src="/images/logo.png" alt="Larablog" class="logo_200 mx-auto d-block">
      </div>
      <div class="card-body">        
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" >Nombre</span>
          </div>
          <input type="text" class="form-control" v-model="name">
        </div>      
        <div class="input-group mt-3">
          <div class="input-group-prepend">
            <span class="input-group-text" >Apellidos</span>
          </div>
          <input type="text" class="form-control" v-model="surname">
        </div>
        <div class="input-group mt-3">
          <div class="input-group-prepend">
            <span class="input-group-text" >email</span>
          </div>
          <input type="email" class="form-control" v-model="email">
        </div>
        <div class="input-group mt-3">
          <textarea class="form-control" placeholder="Comentarios" v-model="content">}</textarea>
        </div>
        <button @click="saveContact" class="btn btn-primary float-right btn-lg mt-3">Enviar</button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created:{

  },
  methods: {
    saveContact:function(){
      console.log(this.name);
      console.log(this.surname);
      console.log(this.email);
      console.log(this.content);
      return;
    }
  },
  data:function(){
    return{
      name:"",
      surname:"",
      email:"",
      content:"",
    }
  }
}
</script>