<template>

    <header>
      <nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <router-link class="nav-link active" aria-current="page" to="/home"><h1 class="h1-nav">Control Study</h1></router-link>    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-user">{{ this.user }}</span>
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <!-- <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/admin">Админ</router-link>        
        </li> -->
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home">Главная</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/marks" v-if="student">Оценки</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/users">Пользователи</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/dashboard" v-if="admin">Отчет</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/configurate" v-if="admin">Настройки</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/timetable" v-if="student">Расписание</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/lessons" v-if="student">Уроки</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/allTimeTable" v-if="teacher">Расписание</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/adminTimeTable" v-if="admin">Расписание</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link active" aria-current="page" to="/home/subjects" v-if="teacher">Предметы</router-link>
        </li> 
        <li class="nav-item">
          <a style="cursor: pointer;" class="nav-link active" aria-current="page" @click="logout" >Выход</a>
        </li> 
      </ul>
      
    </div>
  </div>
</nav>
      <!-- <nav class="navbar navbar-dark bg-primary">
        <router-link to="/admin">Админ</router-link>
        <router-link to="/button" >Click</router-link>
        <router-link to="/registr" >Регистрация</router-link>
        <router-link to="/home/marks" >Оценки</router-link>
        <router-link to="/home/users" >Пользователи</router-link>
        <router-link to="/home/dashboard" >Отчет</router-link>
        <a @click="logout" >Выход</a>
      </nav> -->
       <!-- <ul class="navigation-menu">
        <li><router-link to="/admin" class="rout">Админ</router-link></li>
        <li><router-link to="/button" class="rout">Click</router-link></li>
        <li><router-link to="/registr" class="rout">Регистрация</router-link></li>
        <li><router-link to="/home/marks" class="rout">Оценки</router-link></li>
        <li><router-link to="/home/users" class="rout">Пользователи</router-link></li>
        <li><router-link to="/home/dashboard" class="rout">Отчет</router-link></li>
        <li><a @click="logout" class="rout">Выход</a></li>
      </ul> -->
    <router-view></router-view>
    </header>
      
</template>
<style >
  @import '/node_modules/bootstrap/dist/css/bootstrap.css';
    * {
    padding: 0;
    margin: 0;
    }
    body{
      margin: 0;
    }
    .navbar-user{
      color: white;
      margin-right: 2vw;
    }
    header{
      margin-bottom: 1vw;
    }
    .h1-nav{
      color: white;
    }
    .navigation-menu {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #343b9c;
  }

  li {
    float: left;
  }

  .rout{
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  .rout:hover {
    background-color: #8d80c5;
  }
  header{
    width: 100%;
  }

</style>
    
<script>
        import { delCookie } from '../cookie';
        import { getCookie } from '../cookie';
        import { setCookie } from '../cookie';
    export default {
      data() {
            return {
                user: null,
                student: false,
                admin: false,
                teacher:false
            }
        },
        methods: {
          getToken(){
            if(localStorage.getItem('token')){
              //alert('Авторизован');
            }
          },
          logout(){
            localStorage.removeItem('token');
            axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.post('/logout', {})
                        .then((response) => {
                            // console.log(response);
                            // console.log(response.config.headers['X-XSRF-TOKEN']);
                            // localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            this.$router.push('/admin');                            
                        }).catch(error=>{
                            this.$router.push('/admin');
                        })
                })           
            //this.$router.push('/admin');
          },
          getProfile(){
            // axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.get('http://127.0.0.1:8000/api/profileGet')
                        .then((response) => {
                            console.log(response);
                            this.admin = false;
                            this.student = false;
                            this.teacher = false;
                            this.user = response.data[0].name;
                            if(response.data[0].student_id == null && response.data[0].id_teacher == null){
                              this.admin = 'admin';
                            }
                            this.student = response.data[0].student_id;
                            this.teacher = response.data[0].id_teacher;
                           
                        }).catch(error=>{
                            // alert("Неверные данные пользователя");
                            console.log(error);
                        })
                // })
        }
        },
        mounted() {
            this.getToken();
            this.getProfile();
        }
    }
</script>