<template>
    <v-header></v-header>
    <div style = "margin-left: 2vw">
    <div>{{ user.teacher_name }}</div>
    <div class="d-flex">
        <p style="font-weight: bold;">Фамилия</p>
        <div class="ms-2">Шапкин</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Имя</p>
        <div class="ms-2">Илья</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Отчество</p>
        <div class="ms-2">Гамлетович</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Адрес</p>
        <div class="ms-2">г.Липецк улица Рябиновая д.25</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Телефон</p>
        <div class="ms-2">89171025682</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Класс</p>
        <div class="ms-2">7А</div>
    </div>
    <div class="d-flex">
        <p style="font-weight: bold;">Классный руководитель</p>
        <div class="ms-2">Королева Елизавета Викторовна</div>
    </div>
    
</div>
</template>
<script>

      export default{
    
      data(){
          return{ 
            user: {

            }

        
          }
      },
      methods: {
        getUser(){
            axios.post('http://127.0.0.1:8000/api/profile', {id: this.$route.params.id})
                .then((response) => {
                    console.log(response);
                    this.user = response.data[0]; 
                    console.log(this.user);                         
                }).catch(error=>{
                    console.log(error);
                })                
            },
        
        getProfile(){
            // axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.get('http://127.0.0.1:8000/api/profileGet')
                        .then((response) => {
                            console.log(response);
                           
                        }).catch(error=>{
                            // alert("Неверные данные пользователя");
                            console.log(error);
                        })
                // })
        },
    },
      

      mounted() {
          this.getUser();
          this.getProfile();
      },
  
  }
  </script>