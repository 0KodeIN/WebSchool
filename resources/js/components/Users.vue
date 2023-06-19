<template>
    <v-header></v-header>   
        <div class="wrapper-users"> 
                <div class="w-50 d-flex justify-content-between ">
                    <div class="dropdown mt-0">
      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        Пользователи
      </button>
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#" @click="getUserGroup(this.student)">Ученики</a></li>
        <li><a class="dropdown-item" href="#" @click="getUserGroup(this.teacher)">Педагоги</a></li>
      </ul>
    </div>

          <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
          <input type="text" class="form-control" readonly v-model="category">

        <router-link to="/home/users/create" class="btn btn-primary mt-0">Добавить</router-link>
        </div>
        <div class="users-container" v-if="list==1">
            <div class="w-50 d-flex justify-content-between">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Класс
                </button>
                <div class="w-75 d-flex justify-content-between">
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li v-for="elem in classes"><a class="dropdown-item" href="#" @click="getUsersClass">{{ elem }}</a></li>
                </ul>

                    <input type="text" class="form-control" v-model="search">

                <button class="btn btn-primary mt-0 vw-500" @click="searchContext">Поиск</button>
                </div>
                
            </div>
            
            <ul class="list-group mt-3" >
                <div class="d-flex ms-2 align-items-center" v-for="elem in menu">
                <li class="list-group-item mt-2" aria-current="false"  :id=elem.id @click="routeToProfile(elem.student_id)">
                    {{ elem.student_name + " " + elem.student_surname }}
                </li>
                <button type="button" class="btn-close ms-2" aria-label="Close" width="30" height="30" @click="deleteUser(elem.id)"></button>
                </div>
            </ul>  
        </div>
        <div class="users-container" v-if="list==2">
            <div class="w-50 d-flex justify-content-between">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Предмет
                </button>
                <div class="w-75 d-flex justify-content-between">
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#" @click="getTeachers">Русский язык</a></li>
                    <li><a class="dropdown-item" href="#" @click="getTeachers">Математика</a></li>
                    <li><a class="dropdown-item" href="#" @click="getTeachers">Литература</a></li>
                </ul>

                    <input type="text" class="form-control" v-model="search">

                <button class="btn btn-primary mt-0 vw-500" @click="searchContext">Поиск</button>
                </div>
                
            </div>
            
            <ul class="list-group mt-3" >
                <li class="list-group-item" aria-current="false" v-for="elem in menu" :id=elem.id @click="routeToProfile(elem.id_teacher)">
                    {{ elem.teacher_surname + " " + elem.teacher_name }}
                </li>
            </ul>  
        </div> 

           
    <!-- <div v-if="list!=0">    
    <section style="margin-top: 5vw;">
          <ul class="list5b">
            <li  v-for="elem in menu" :id=elem.id @click="routeToProfile(elem.student_id)">
                {{ elem.id_class + " A "  + elem.student_name + " " + elem.student_patronomyc + " " + elem.student_id }}                         
            </li>
          </ul>
    </section>
    </div> -->
    </div>
    
  </template>
  <script>

      export default{
    
      data(){
          return{ 

              menu:  [
                // { adress: "", id_class: "", phone: " ", student_id: " ", student_name: " ", student_patronomyc: " ", student_surname: " ", }
              ],
              static: [
                { adress: "", id_class: "", phone: " ", student_id: " ", student_name: " ", student_patronomyc: " ", student_surname: " ", }
              ],
              list: "",
              category: "",
              teacher: "Педагоги",
              student: "Ученики",
              admins: "Администраторы",
              search: "",
              searchClass: "",
              searchWord: "",
              classes : []
          }
      },
      methods: {
        getAllUsers(){

                    axios.get('http://127.0.0.1:8000/api/students')
                        .then((response) => {
                            console.log(response);
                            for(let i = 0; i < response.data.length; i++){
                                this.menu[i] = response.data[i];
                            }
                            // this.adress = response.data[5].adress;
                            console.log(this.menu[4]);
                            // console.log(response.config.headers['X-XSRF-TOKEN']);
                            // localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            // this.$router.push('/home');                            
                        }).catch(error=>{
                            alert(error);
                        })
  
                
            },
            deleteUser(id){
              console.log(id)
              axios.post('http://127.0.0.1:8000/api/deleteUser', {id:id})
                        .then((response) => {
                            console.log(response);
                            // console.log(this.table[0].week_day);
                            // for(let i = 0; i < this.table.length; i++){
                            //         this.table.push(response.data[i])
    
                            // }
                            console.log(this.table);
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            searchContext(){
                axios.post('http://127.0.0.1:8000/api/search', {search: this.search})
                        .then((response) => {
                            console.log(response);
                            this.menu = [
                { adress: "", id_class: "", phone: " ", student_id: " ", student_name: " ", student_patronomyc: " ", student_surname: " ", }
              ];
                            // for(let index = 0; index < this.menu.length; index++){
                            //     this.menu.splice(index,1);
                            // }                            
                            for(let i = 0; i < response.data.length; i++){
                                this.menu[i] = response.data[i];
                            }
                            // this.adress = response.data[5].adress;
                            console.log(this.menu[4]);
                            // console.log(response.config.headers['X-XSRF-TOKEN']);
                            // localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            // this.$router.push('/home');                            
                        }).catch(error=>{
                            console.log(error.response.data.message);
                        })
            },
            getUsersClass(){
                this.searchClass = 7;
                this.searchWord = 'а';
                this.menu = [];
                axios.post('http://127.0.0.1:8000/api/class', {searchClass: this.searchClass, searchWord: this.searchWord})
                        .then((response) => {
                            console.log(response);
                            for(let i = 0; i < response.data.length; i++){
                                this.menu[i] = response.data[i];
                            }
                            // this.adress = response.data[5].adress;
                            // console.log(this.menu[4]);
                            // console.log(response.config.headers['X-XSRF-TOKEN']);
                            // localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            // this.$router.push('/home');                            
                        }).catch(error=>{
                            console.log(error.response.data.message);
                        })
            },
            getUserGroup(value){
                if(value == 'Ученики'){
                    this.list = 1;
                    this.category = 'Ученики';
                    this.getClass();
                }
                if(value == 'Педагоги'){
                    this.list = 2;
                    this.category = 'Учителя';
                }
                if(value == 'Администраторы'){
                    this.list = 3;
                    this.category = 'Администраторы';
                }
            },
            routeToProfile(id){
                this.$router.push("/profile/" + id);
            },
            getClass(){
                axios.get('http://127.0.0.1:8000/api/allClass') 
                .then((response) => {
                    console.log(response.data);
                    this.classes = response.data;
                    console.log(this.classes);
                                             
                }).catch(error => {
                    console.log(error);
                }) 
            },
            getTeachers(){
                let searchSubject = 'Русский язык';
                this.menu = [];
                axios.post('http://127.0.0.1:8000/api/searchTeacher', {subject:searchSubject} )
                        .then((response) => {
                            console.log(response);
                            this.menu = [
                                {   
                                    adress: "", 
                                    id_class: "", 
                                    phone: " ", 
                                    student_id: " ", 
                                    student_name: " ", 
                                    student_patronomyc: " ", 
                                    student_surname: " ", 
                                }
                            ];
                            this.menu = response.data;
                            for(let i = 0; i < response.data.length; i++){
                                
                                // this.menu[i].student_name = response.data[i].teacher_name;
                                // this.menu[i].student_surname = response.data[i].teacher_surname;
                            }
                            console.log(this.menu);
                            // this.adress = response.data[5].adress;
                            // console.log(this.menu[4]);
                            // console.log(response.config.headers['X-XSRF-TOKEN']);
                            // localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            // this.$router.push('/home');                            
                        }).catch(error=>{
                            // console.log(error.response.data.message);
                        })
            },
      },

      mounted() {
        //   this.getAllUsers();
      },
  
  }
  </script>
  <style scoped>
  @import '/node_modules/bootstrap/dist/css/bootstrap.css'; 
    .search-container{
        width: 1000px;
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        text-align: center;
        height: 50px;
    }
    .users-container{
        margin-top: 3vw;
        border: 2px solid gainsboro;
        padding: 2vw;
    }
    .form-control{
        width: 250px;
    }
    /* .btn{
        height: 35px;
        margin-top: 30px;
    } */
    .input-group{
        width: 300px;
    } 
    .wrapper-users{
        width: 90%;
        margin: 0 auto;
        margin-top: 2vw;
    }
    .dropbtn {
        background-color: #007FFF;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
        cursor: pointer;
  }

  .dropdown {
    position: relative;
    display: inline-block;
    z-index: 2;
    margin-top: 1vw;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  }

  .dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-content a:hover {background-color: #f1f1f1}

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .dropdown:hover .dropbtn {
    background-color: #007FFF;
  }
.list5b {
    padding:0;
    list-style: none;
    width: 25vw;
}    
.list5b li {
    width: 50%;
    position: relative;
    padding: 10px 30px;
    background: linear-gradient(to left, #EFEFEF 0%, #FFF, #EFEFEF);
    border: 2px solid #C0C0C0;
    color: #506a6b;
    box-shadow: 0 5px 5px 0 rgba(0,0,0, .2);
    margin-bottom: 5px;
    text-align:center;
    background-size: 100% 100%;
    z-index: 1;
}
.list5b li:hover {
    border: 2px solid #ADCEE9;
}
.list5b li:before {
    content: "";
    position:absolute;
    width: 0;
    height: 100%;
    top: 50%;
    left: 50%;
    background: linear-gradient(to left, #E2F0FA 0%, #FFF, #E2F0FA);
    opacity: 0;
    -webkit-transform: translateX(-50%) translateY(-50%);
    -moz-transform: translateX(-50%) translateY(-50%);
    -ms-transform: translateX(-50%) translateY(-50%);
    transform: translateX(-50%) translateY(-50%);
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
    z-index: -1;
}
.list5b li:hover:before {
    width: 100%;
    opacity: 1;
}    
    .v-li{
        background-color: white;
        display: flex;
        justify-content: space-between;
    }
    .v-ul{
        width: 50vw;
        background-color: white;
    }
    .v-p{
        margin-left: 1vw;
    }
    .marks{
        display: flex;
        width: 80%;
        margin-top: 3vw;
    }
    .menu{
        margin-left: 3vw;
        display: flex;
        flex-wrap: wrap;
        list-style-type: none;
        background-color: #007FFF;
        font-size: 22px;
        padding: 2vw 2vw;
        width: 35vw;
    }
    li{
        /* margin-top: 1vw;
        margin-left: 1vw;
        cursor: pointer; */
    }
    .table-marks{
        width: 100%;
        background-color: white;
        border: 1px solid #007FFF;
    }
    .object1{
      color: white;
    }
    .head_mark{
        display: flex;
        margin-right: 3vw;
        /* flex-wrap: wrap; */

    }
  
  </style>