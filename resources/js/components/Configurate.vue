<template>
    <v-header></v-header>
    <nav class="navbar navbar-light ">
  <div class="container-fluid">
    <form class="d-flex justify-content-around">
          <a class="nav-link active ms-5" aria-current="page" href="#" id="subject" @click="getNavItem('subject')">Предметы</a>
          <a class="nav-link ms-5" href="#" id="classroom" @click="getNavItem('classroom')">Кабинеты</a>
          <a class="nav-link ms-5" href="#" id="class" @click="getNavItem('class')">Классы</a>
          <a class="nav-link ms-5" href="#" id="post" @click="getNavItem('post')">Объявления</a>
    </form>
  </div>
</nav>
<div class="div" v-if="subject">
 
   <div class="form-file form-file-sm ms-5 mt-2">
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">

  <button class="btn btn-primary" @click="submitFile()">Загрузить Предметы</button>
  
</div>
<div class="mb-3"> 
    <div class="container mt-2  ms-5 pt-2 pb-2" style="height: 150px; width: 250px; border: 1px solid blue; overflow: auto;">
        <ul class="list-group">
        <div class="d-flex" v-for="elem in subjects">
        <li class="list-group-item m-0  ms-1 mt-1" style="width: 161px;"> {{elem.subject_name}} </li>
        <button type="button" class="btn-close ms-2 mt-2" aria-label="Close" width="30" height="30" @click="deleteSubject(elem.id_subject)"></button>
        </div>     
    </ul>
    </div>

</div>
</div>
<div class="div" v-if="classroom">
<div class="form-file form-file-sm ms-5 mt-2">
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">

  <button class="btn btn-primary" @click="submitFileClassrooms()">Загрузить Кабинеты</button>
  
</div>
<div class="mb-3"> 
    <div class="container mt-2  ms-5 w-25" style="height: 150px; border: 1px solid blue; overflow: auto;">
        <ul class="list-group ">
            <div class="d-flex" v-for="elem in classrooms">
                <li class="list-group-item m-0  ms-1 mt-1" style="width: 150px;" > {{elem.class_number}} </li>
                <button type="button" class="btn-close ms-2 mt-2" aria-label="Close" width="30" height="30" @click="deleteClassRoom(elem.class_number)"></button>
            </div>
        
      </ul>
    </div>

</div>
</div>
<div class="div" v-if="class">
<div class="form-file form-file-sm ms-5 mt-2">
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">

  <button class="btn btn-primary" @click="submitFileClass()">Загрузить список классов</button>
  
</div>
<div class="mb-3"> 
    <div class="container mt-2 w-25 ms-5" style="height: 150px; border: 1px solid blue; overflow: auto;">
        <ul class="list-group ">
        <div class="d-flex" v-for="elem in classes">
                <li class="list-group-item m-0  ms-1 mt-1" style="width: 150px;" > {{elem}} </li>
                <button type="button" class="btn-close ms-2 mt-2" aria-label="Close" width="30" height="30" @click="deleteClass(elem)"></button>
            </div>
      </ul>
    </div>

</div>
</div>
<div class="div" v-if="post">
<div class="form-file form-file-sm ms-5 mt-2">
  

  <button class="btn btn-primary" @click="newPost">Добавить Объявление</button>
  
</div>
<div class="mb-3"> 
    <div class="container mt-2 w-25 ms-5" style="height: 150px; border: 1px solid blue; overflow: auto;">
        <ul class="list-group ">
        <div class="d-flex" v-for="elem in posts">
                <li class="list-group-item m-0  ms-1 mt-1" style="width: 200px;" > {{elem.header}} № {{ elem.post_id }} </li>
                <button type="button" class="btn-close ms-2 mt-2" aria-label="Close" width="30" height="30" @click="deletePost(elem.post_id)"></button>
            </div>
      </ul>
    </div>

</div>
</div>
<!-- <div class="form-file form-file-sm ms-5 mt-2">
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">
  <label class="form-file-label" for="customFileSm">
    <span class="form-file-text">Загрузите файл с расписанием</span>
    <span class="form-file-button">Browse</span>
  </label>
  <button class="btn btn-primary" @click="submitFile()">Загрузить список кабинетов</button>
</div> -->
<div class="d-flex ms-5 mb-2 mt-2">
  <!-- <input type="text" class="form-control w-25"  @change="handleFileUpload()"> -->
  <!-- <label class="form-file-label" for="customFileSm">
    <span class="form-file-text">Загрузите файл с расписанием</span>
    <span class="form-file-button">Browse</span>
  </label> -->
</div>

  <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Занятие</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click = "this.checked = false"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Заголовок</label>
    <input type="text" class="form ms-2" id="start" v-model="headerPost">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Новый текст</label>
    <textarea id="w3review" name="w3review" rows="4" cols="50" v-model="headerText">

</textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="setPost">Добавить</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                table: [],
                checked: false,
                subjects: [],
                classrooms: [],
                classes: [],
                subject: true,
                classroom: false,
                class: false,
                modal: false,
                post: false,
                posts: [],
                headerPost: '',
                headerText: ''
                
            }
        },
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            submitFile(){
                    console.log(this.file);
                    const formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('http://127.0.0.1:8000/api/setSubjects', formData)
                        .then((response) => {
                            console.log(response);
                            this.file = null;
                            location.reload();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                        
            },
            setPost(){
                    console.log(this.headerPost);
                    console.log(this.headerText);                   
                    axios.post('http://127.0.0.1:8000/api/setPost', {header:this.headerPost, content:this.headerText})
                        .then((response) => {
                            console.log(response);
                            location.reload();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            submitFileClassrooms(){
                    console.log(this.file);
                    const formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('http://127.0.0.1:8000/api/setClassRoom', formData)
                        .then((response) => {
                            console.log(response);
                            this.file = null;
                            location.reload();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                        
            },
            submitFileClass(){
                    console.log(this.file);
                    const formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('http://127.0.0.1:8000/api/setClass', formData)
                        .then((response) => {
                            console.log(response);
                            this.file = null;
                            location.reload();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                        
            },   
            getNavItem(id){
                if(this.modal){
                    this.modal.style.color = 'black';
                }
                this.modal = document.getElementById(id);
                this.modal.style.color = 'blue';
                if(id == 'subject'){
                    this.subject = true;
                    this.class = false;
                    this.classroom = false;
                    this.post = false;
                }
                if(id == 'classroom'){
                    this.subject = false;
                    this.class = false;
                    this.classroom = true;
                    this.post = false;
                }
                if(id == 'class'){
                    this.subject = false;
                    this.class = true;
                    this.classroom = false;
                    this.post = false;
                }
                if(id == 'post'){
                    this.subject = false;
                    this.class = false;
                    this.classroom = false;
                    this.post = true;
                }     
            },
            newPost(){
                let modalLesson = new Modal(document.getElementById('newModal'));
                modalLesson.show();
            },
            getTable(){
                this.modal = document.getElementById('subject');
                this.modal.style.color = 'Blue';
                axios.get('http://127.0.0.1:8000/api/table')
                        .then((response) => {
                            console.log(response);
                            this.table = response.data;
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
            getPosts(){

                axios.get('http://127.0.0.1:8000/api/getPosts')
                        .then((response) => {
                            console.log(response);
                            this.posts = response.data;
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            deleteRow(id){
              console.log(id)
              axios.post('http://127.0.0.1:8000/api/deleteRow', {tid_timetable:id})
                        .then((response) => {
                            console.log(response);
                            // console.log(this.table[0].week_day);
                            // for(let i = 0; i < this.table.length; i++){
                            //         this.table.push(response.data[i])
    
                            // }
                            console.log(this.table);
                            location.reload();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            setTimeTable(){
                this.checked = true;
                let myModal = new Modal(document.getElementById('newModal'));
                myModal.show();

            },
            getAllClassrooms(){
                axios.get('http://127.0.0.1:8000/api/getOffices')
                        .then((response) => {
                            console.log(response);
                            this.classrooms = response.data;
                        }).catch(error=>{
                            console.log(error.response);
            })
        },
        getAllClass(){
                axios.get('http://127.0.0.1:8000/api/allClass')
                        .then((response) => {
                            console.log(response);
                            this.classes = response.data;
                        }).catch(error=>{
                            console.log(error.response);
            })
        },
           
            getAllSubjects(){
                axios.get('http://127.0.0.1:8000/api/getAllSubjects')
                        .then((response) => {
                            console.log(response);
                            this.subjects = response.data;
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            deleteClassRoom(id){
                axios.post('http://127.0.0.1:8000/api/deleteClassRoom',{class_id:id})
                        .then((response) => {
                            console.log(response);
                            location.reload();
                           
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            deleteClass(id){
                axios.post('http://127.0.0.1:8000/api/deleteClass',{id_class:id})
                        .then((response) => {
                            console.log(response);
                            location.reload();
                           
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            deletePost(id){
                axios.post('http://127.0.0.1:8000/api/deletePost',{post_id:id})
                        .then((response) => {
                            console.log(response);
                            location.reload();
                           
                        }).catch(error=>{
                            console.log(error.response);
                        })
            },
            deleteSubject(id){
                axios.post('http://127.0.0.1:8000/api/deleteSubject',{id_subject:id})
                        .then((response) => {
                            console.log(response);
                            location.reload();
                           
                        }).catch(error=>{
                            console.log(error.response);
                        })
            }  

            
        },
        mounted() {
            this.getTable();
            this.getAllSubjects();
            this.getAllClassrooms();
            this.getAllClass();
            this.getPosts();
            
        },
        watch: {
  showModal(val) {
    $(this.$refs.modal).modal(val ? 'show' : 'hide');
  },
},
    }
</script>
