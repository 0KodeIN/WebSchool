<template>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="checked">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ошибка</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Неверный логин или пароль
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<form>
  <label class="label-login">Вход в систему</label> 
  <div id="wrapper">
    <div id="arrow"></div>
    <input v-model="email" id="email" placeholder="Логин" type="text">
    <input v-model="password" id="pass" placeholder="Пароль" type="password">
  </div>
  <input @click.prevent = "login" type="submit" value="Войти" class="login-btn">
</form>
</template>
<style scoped>
@import '/node_modules/bootstrap/dist/css/bootstrap.css';
        .label-login{
            margin-left: 8.5vw;
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





        @import url(http://fonts.googleapis.com/css?family=Raleway:700,800);

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
}
    </style>
    
    <script>
        import axios from 'axios';
        import * as bootstrap from 'bootstrap';
        window.Modal = bootstrap.Modal;
        import { delCookie } from '../cookie';
        import { getCookie } from '../cookie';
        import { setCookie } from '../cookie';
        
        export default {
        data() {
            return {
                email: null,
                password: null,
                content: null,
                checked: true
            }
        },
        methods: {
            login(){
                console.log(this.email);
                console.log(this.password);
                // delCookie('XSRF-TOKEN'); 
                // delCookie('laravel_session');
                // axios.get('sanctum/csrf-cookie').then((response) => {
                //     axios.post('/logout', {email: this.email, password: this.password})
                //         .then((response) => {
                //             console.log(response);
                //             console.log(response.config.headers['X-XSRF-TOKEN']);                                                     
                //         }).catch(error=>{
                //             //alert("Неверные данные пользователя");
                //             console.log(response);
                //         })
                // })        
                axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.post('/login', {name: this.email, password: this.password})
                        .then((response) => {
                            console.log(response);
                            console.log(response.config.headers['X-XSRF-TOKEN']);
                            localStorage.setItem('token', response.config.headers['X-XSRF-TOKEN']);
                            this.$router.push('/home');                            
                        }).catch(error=>{
                            // alert("Неверные данные пользователя");
                            this.checked = true;
                            let myModal = new Modal(document.getElementById('exampleModal'));
                            myModal.show();
                            console.log(error);
                        })
                })
                
            },                      
        },
        mounted() {
            //console.log('Component mounted.')
        },
        watch: {
  showModal(val) {
    $(this.$refs.modal).modal(val ? 'show' : 'hide');
  },
},
    }
    </script>