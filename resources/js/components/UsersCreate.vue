<template>
    <v-header></v-header>
  <form class="row g-3">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Email</label>
    <input type="email" class="form-control" id="inputEmail4" v-model="email">
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label">Логин</label>
    <input type="text" class="form-control" v-model="name">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Адрес</label>
    <input type="text" class="form-control" id="inputAddress" v-model="adress">
  </div>
  <div class="col-12">
    <label for="inputAddress2" class="form-label">Телефон</label>
    <input type="text" class="form-control" v-model="phone">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">Имя</label>
    <input type="text" class="form-control" id="inputCity" v-model="p_name">
  </div>
  <div class="col-md-4">
    <label for="inputCity" class="form-label">Фамилия</label>
    <input type="text" class="form-control" id="inputCity" v-model="p_surname">
  </div>
  <div class="col-md-6">
    <label for="inputCity" class="form-label">Отчество</label>
    <input type="text" class="form-control" id="inputCity" v-model="p_patronomyc">
  </div>
  <div class="col-md-4">
    <label for="inputState" class="form-label">Роль</label>
    <select id="inputState" class="form-select"  v-model="role">
      <option>Ученик</option>
      <option>Учитель</option>
      <option>Администратор</option>
    </select>
    
    <div class="d-flex" style="align-items: center;">
      <label for="inputState" class="form-label mt-2" v-if= "this.role == 'Учитель' ">Предмет</label>
    <svg v-if= "this.role == 'Учитель'" @click="count++;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
    <button v-if= "this.role == 'Учитель'" @click="count--;" type="button" class="btn-close" aria-label="Close" width="30" height="30"></button>      
    </div>
    
    <select id="inputState" class="form-select"  v-if= "this.role == 'Учитель'" v-model="subject1">
      <option v-for="elem in subjects">{{ elem.subject_name }}</option>
    </select>    
    <select id="inputState" class="form-select"  v-if= "this.role == 'Учитель' &&  this.count >=1" v-model="subject2">
      <option v-for="elem in subjects">{{ elem.subject_name }}</option>
    </select>
    <select id="inputState" class="form-select"  v-if= "this.role == 'Учитель' &&  this.count > 1" v-model="subject3">
      <option v-for="elem in subjects">{{ elem.subject_name }}</option>
    </select>
    <div class="col-md-6" v-if="this.role == 'Ученик'">
    <label for="inputCity" class="form-label mt-1">Класс</label>
    <input type="text" class="form-control" id="inputCity">
  </div>
  </div>
  <!-- <div class="col-md-2">
    <label for="inputZip" class="form-label">Zip</label>
    <input type="text" class="form-control" id="inputZip">
  </div> -->
  <div class="col-12">
    <!-- <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Я согласен на обработку персональных данных
      </label>
    </div> -->
  </div>
  <div class="col-12">
    <input @click.prevent = "register" type="submit" value="Добавить" class="btn btn-primary">
  </div>
</form>    
    <!-- <form>
  <label class="label-login">Добавить пользователя</label> 
  <div id="wrapper">
    <div id="arrow"></div>
    <input v-model="email" type="text" placeholder="email">
    <input v-model="name" type="text" placeholder="name">
    <input v-model="password" type="password" placeholder="password">
    <input v-model="password_confirnation" type="password" placeholder="confirm password">
  </div>
  <input @click.prevent = "register" type="submit" value="Добавить" class="login-btn">
</form> -->

</template>
<style scoped>
@import '/node_modules/bootstrap/dist/css/bootstrap.css';
.row{
  padding: 2vw;
}
.form-control{
  width: 30vw;
}
form{
  width: 90%;
}
/* .label-login{
    margin-left: 13vw;
}
.auth_form{
    display: flex;
    flex-wrap: wrap;
    width: 100px;
    margin: 100px auto;
    box-sizing: border-box;
}
.login-btn{
  background: #079BCF;
  border: none;
  border-radius: 8px;
  color: #fff;
  cursor: pointer;
  font-family: 'Raleway', sans-serif;
  font-size: 27px;
  height: 72px;
  width: 100%;
  margin-bottom: 10px;
  overflow: hidden;
  transition: all .3s cubic-bezier(.6,0,.4,1);
}
.login-btn:hover {
    background: #007BA5;
}
.login-text{
    width: 96px;
}
html, body { margin: 0; }

:focus { outline: none; }
::-webkit-input-placeholder { color: #DEDFDF; }
::-moz-placeholder { color: #DEDFDF; }
:-moz-placeholder { color: #DEDFDF; }
::-ms-input-placeholder { color: #DEDFDF; }

body {
  background: #6ED0F6;
  color: #fff;
  font-family: 'Raleway', sans-serif;
  -webkit-font-smoothing: antialiased;
}

#wrapper, label, #arrow, button span { transition: all .5s cubic-bezier(.6,0,.4,1); }

#wrapper { overflow: hidden; }

#signin:checked ~ #wrapper { height: 178px; }
#signin:checked ~ #wrapper #arrow { left: 32px; }
#signin:checked ~ button span { transform: translate3d(0,-72px,0); }

#signup:checked ~ #wrapper { height: 262px; }
#signup:checked ~ #wrapper #arrow { left: 137px; }
#signup:checked ~ button span { transform: translate3d(0,-144px,0); }

#reset:checked ~ #wrapper { height: 94px; }
#reset:checked ~ #wrapper #arrow { left: 404px; }
#reset:checked ~ button span { transform: translate3d(0,0,0); }

form {
  width: 450px;
  height: 370px;
  margin: -185px -225px;
  position: absolute;
  left: 50%;
  top: 50%;
}

input[type=radio] { display: none; }

label {
  cursor: pointer;
  display: inline-block;
  font-size: 22px;
  font-weight: 800;
  opacity: .5;
  margin-bottom: 30px;
  text-transform: uppercase;
}
label:hover {
  transition: all .3s cubic-bezier(.6,0,.4,1);
  opacity: 1;
}
label[for="signin"] { margin-right: 20px; }
label[for="reset"] { float: right; }
input[type=radio]:checked + label { opacity: 1; }

input[type=text],
input[type=password] {
  background: #fff;
  border: none;
  border-radius: 8px;
  font-size: 27px;
  font-family: 'Raleway', sans-serif;
  height: 72px;
  width: 99.5%;
  margin-bottom: 10px;
  opacity: 1;
  text-indent: 20px;
  transition: all .2s ease-in-out;
}
button {
  background: #079BCF;
  border: none;
  border-radius: 8px;
  color: #fff;
  cursor: pointer;
  font-family: 'Raleway', sans-serif;
  font-size: 27px;
  height: 72px;
  width: 100%;
  margin-bottom: 10px;
  overflow: hidden;
  transition: all .3s cubic-bezier(.6,0,.4,1);
}
button span {
  display: block;
  line-height: 72px;
  position: relative;
  top: -2px;
  transform: translate3d(0,0,0);
}
button:hover {
  background: #007BA5;
}

#arrow {
  height: 0;
  width: 0;
  border-bottom: 10px solid #fff;
  border-left: 10px solid transparent;
  border-right: 10px solid transparent;
  position: relative;
  left: 32px;
}


#hint {
  width: 100%;
  text-align: center;
  position: absolute;
  bottom: 20px;
} */
</style>
<script>
        import axios from 'axios';
        export default {
        data() {
            return {
                email: null,
                password: null,
                content: null,
                name: null,
                password_confirnation: null,
                phone: null,
                adress: null,
                p_name: null,
                p_surname: null,
                p_patronomyc: null,
                subjects: [],
                teacher_subjects: [],
                role:null,
                subject1: null,
                subject2: null,
                subject3: null,
                count: null
            }
        },
        methods: {
            register(){
                if(this.email == null){
                  this.email = this.name + '100801@mail.ru';
                }
                this.password = this.name + this.phone;
                axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.post('/createuser', {
                      name: this.name, 
                      email: this.email, 
                      password: this.password, 
                      password_confirnation: this.password,
                      role: this.role,
                      phone: this.phone,
                      adress: this.adress,
                      p_name: this.p_name,
                      p_patronomyc: this.p_patronomyc,
                      p_surname: this.p_surname,
                      subject1: this.subject1,
                      subject2: this.subject2,
                      subject3: this.subject3,
                    })
                        .then((response) => {
                            console.log(response);
                            this.content = response.data;
                            location.reload();
                        })
                })
                
            },
          getAllSubjects() {

            axios.get('http://127.0.0.1:8000/api/subjects')
              .then((response) => {
                console.log(response);
                for (let i = 0; i < response.data.length; i++) {
                      this.subjects[i] = response.data[i];
                }                         
                }).catch(error => {
                      console.log(error);
                })
          },
          getRole(value){
            if(value == 1) this.role = 1;
            console.log(this.role)
          }            
            
        },
        mounted() {
          this.getAllSubjects();
        }
    }
    </script>