<template>

    <v-header></v-header>
    
    <!-- <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    Кнопка выпадающего списка
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="#">Действие</a></li>
    <li><a class="dropdown-item" href="#">Другое действие</a></li>
    <li><a class="dropdown-item" href="#">Что-то еще здесь</a></li>
  </ul>
</div> -->
    <!-- <div class="d-flex justify-content-start"> -->
     
      <!-- <ul class="list-group">
        <li class="list-group-item m-0" :id=elem.id v-for="elem in menu" @click="getMarks(elem.subject_name)">{{ elem.subject_name }}</li>
      </ul> -->
    <!-- <div class="mark-table" v-if="mark==1">
      <div class="d-flex justify-content-around" style="width: 80vw; align-items: center;">
          <span>С </span>
          <input type="date" class="form" id="start" name="trip-start"
          
          min="2019-09-01" max="2023-05-31" v-model="start_date">
            <span>По </span>
            <input type="date" class="form" id="start" name="trip-start"
            
            min="2019-09-01" max="2023-05-31" v-model="end_date">
            <button class="btn btn-primary" @click="getMarks(this.subject)">Фильтровать</button>
            <div class="form-file form-file-sm ms-5">
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()"> -->
  <!-- <label class="form-file-label" for="customFileSm">
    <span class="form-file-text">Загрузите файл с расписанием</span>
    <span class="form-file-button">Browse</span>
  </label> -->
  <!-- <button class="btn btn-primary" @click="submitFile()">Загрузить литературу</button> 
  </div>
      </div> -->
        
    
  
  
<!-- <div class="d-flex">
    <p class="p-flex">Средний балл </p>
  <span>{{ this.average }}</span>
  </div>
  <div class="d-flex">
    <p class="p-flex">Рейтинг </p>
  <span>{{ this.weight }}</span>
  </div>
    </div>
    </div>
    <p v-if="mark==0">Нет данных</p> -->
    <!-- <div>
        <section class="marks">
          <ul class="menu">
            <li :id=elem.id v-for="elem in menu"  class="head_mark">{{ elem.subject_name }}</li>
          </ul>
        <div class="table-marks">{{ subject }}</div>
        </section>        
    </div> -->
    
    <div class="d-flex" >
      <div >
<div v-for="elem in Object.keys(menu)">
      <a   v-bind:href = "getHref(elem)" class="btn btn-primary ms-2 mb-0 mt-2" style="width: 15.1vw;" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    {{ elem }}
  </a>
  <div class="collapse mt-0" v-bind:id = "elem">
  <!-- <div class="card card-body"> -->
    <ul class="list-group ms-2 mt-0">
  <li class="list-group-item mt-0" v-bind:id="elem + value" v-for="value in menu[elem]" @click="getMarkTable(elem,value)">{{ value }}</li>
  <!-- <li class="list-group-item">A second item</li>
  <li class="list-group-item">A third item</li>
  <li class="list-group-item">A fourth item</li>
  <li class="list-group-item">And a fifth one</li> -->
</ul>
    </div>
    
<!-- </div> -->
</div>
      </div>
      <div v-if="detail_active" style="margin-left: 7vw;">
        <span>Дата     {{ this.lessons[0].date_visit[0] }}</span>
  <table class="table" style="text-align: center;">
  <thead>
    <tr>
      <th scope="col">Ученики</th>
      <th scope="col">Посещение</th>
      <th scope="col">Оценка</th>
      <th scope="col">Тип оценки</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="elem in lessons">
      <td>{{ elem.student_surname }}</td>
      <td>   
        <input  type="text"  v-bind:id = "elem.id_visit" v-bind:value="elem.visit"  class="form-control" @change="sendVisit(elem.id_visit)">
      </td>
      <td>
        <input  type="text"  v-bind:id="setNewId(0, elem)" v-bind:value="elem.marks[0]"  class="form-control" @change="setNewMark(setNewId(0, elem))">
      </td>
      <td>
        <input  type="text"  v-bind:id="elem.id_mark[0] + elem.visit" v-bind:value="elem.mark_type[0]"  class="form-control" @change="sendMarkType(elem.id_mark[0] + elem.visit)">
      </td>
      <!-- <td>1</td>
      <td>1</td> -->
    </tr>
  </tbody>
  
 

</table>
<!-- <div class="d-flex" style="width: 100%"> 
  <span style="margin-right: 2vw; font-weight: bold;">Домашнее задание {{ elem. }}</span>
  <input type="text">
</div> -->
<button class="btn btn-primary" @click="returnMark()">Назад</button>
</div> 
      

        <div v-if="table">
          <div class="d-flex ms-5 align-items-center">
            <label v-if="table" for="inputState" class="form-label">Год</label>
        <select v-if="table" id="inputState" class="form-select  m-2" style="width: 10vw;" aria-label="Default select example" v-model="year">
            <option>2022</option>
            <option>2023</option>
            <!-- <option value="2">Two</option>
            <option value="3">Three</option> -->
        </select>
        <label v-if="table" for="inputState2" class="form-label">Четверть</label>
        <select v-if="table" id="inputState2" style="width: 10vw;" class="form-select  m-2" aria-label="Default select example" v-model="chast">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
            <!-- <option value="2">Two</option>
            <option value="3">Three</option> -->
        </select>
        <button class = "btn btn-primary" @click = "getMarkTable('Алгебра', '7б')">Сформировать</button>
        <button class = "btn btn-primary ms-2" @click ="showLiterature()">Литература</button>
          </div>
          
    <table class="table ms-4" v-if="table">
  <thead>
    <tr>
      <th scope="col ms-5">Ученики</th>
      <th scope="col" v-for="unit in date" style="cursor: pointer;" @click="detailLesson(unit.date_visit)">{{(unit.date_visit).replace('2022-','')}}</th>
      <svg @click="showModal()" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>
    </tr>
  </thead>
  <tbody>
    <!-- setMark(n,index,item.date_visit) -->
    <tr v-for="(elem,n) in students">
      <td>{{ elem.student_surname }}</td>
      <!-- v-for="elem in marks.marks" -->
      <!-- v-bind:id = "setId(index,item.date_visit)" -->
      <td v-for="(item, index) in date" >
        <input  type="text" v-bind:id = "setId(n,item.date_visit)" v-bind:value="setMark(n,index,item.date_visit)"  class="form-control" @change="sendMark(setId(n,item.date_visit))">
    </td>
    </tr>
    <!-- <tr>
        <td>Ковалев</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr>
    <tr>
        <td>Коробкин</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr>
    <tr>
        <td>Малышева</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr>
    <tr>
        <td>Петров</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr>
    <tr>
        <td>Шапкин</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr>
    <tr>
        <td>Шацких</td>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"></td>
    </tr> -->
  </tbody>
  

</table>
</div>      
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
    <label for="exampleInputEmail1" class="form-label">Дата занятия</label>
    <input type="date" class="form ms-2" id="start" name="trip-start"
          
          min="2019-09-01" max="2023-05-31"  v-model="dateLesson">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Домашнее задание</label>
    <textarea id="w3review" name="w3review" rows="4" cols="50" v-model="homework">

</textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="setLesson">Добавить</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="litModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Литература по предмету</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">
        <button class="btn btn-primary" @click="submitFile()">Загрузить</button>
        <div class="mb-3 " v-for="elem in books">
          <label for="exampleInputEmail1" class="form-label">{{elem.lit_name}}</label>
          <a for="exampleInputEmail1" v-bind:href="elem.lit_url" class="form-label ms-2">{{elem.lit_url}}</a>
        </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="setLesson">Добавить</button>
      </div>
    </div>
  </div>
</div>


     
  </template>
  <script>


      export default{
    
      data(){
          return{
              menu: [
    
              ],
              marks: [
                
              ],
              students: [

              ],
              date: [

              ],
              lessons: [],
              books: [],
              detail_active: true,
              table: false,  
              subject: "",
              number: 100,
              classObject: {
                  active: true,
                  'point': false
              },
              mark: 2,
              average: 0,
              weight: 0,
              start_date: "",
              end_date: "",
              ocenka: 0,
              checked: false,
              lit: false,
              dateLesson: null,
              homework: null,
              chast: 1,
              year: '2022',
              lesson: '',
              isActive: false,
              detail_active: false,
              markTable: false,
              modal: false,
              file: null,

          }
      },
      methods: {
          showMarks(id, marks) {
            //   if (this.number != 100) {
            //       this.number.style.textDecoration = "none";
            //   }
            //   this.number = document.getElementById(id);
            //   this.number.style.textDecoration = "underline";
            //   this.subject = marks;

          },
          handleFileUpload() {
                this.file = this.$refs.file.files[0];
          },
          returnMark(){
            this.detail_active = false;
            this.table = true;
          },
          submitFile(){
                    const formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('http://127.0.0.1:8000/api/setLit', formData)
                        .then((response) => {
                            console.log(response);
                            this.getFiles();
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                
            },
            getFiles(){
              let subject = 'алгебра';
                    axios.post('http://127.0.0.1:8000/api/getLit', {id: 10007})
                        .then((response) => {
                            console.log(response);
                            this.books = response.data;
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                
            },
          showModal(){
            this.checked = true;
            this.lit = true;
            let modalLesson = new Modal(document.getElementById('newModal'));
           modalLesson.show();

          },
          showLiterature(){
            this.checked = false;
            this.lit = true;
            let modalLit = new Modal(document.getElementById('litModal'));
            modalLit.show();
            this.getFiles();

          },
          detailLesson(id){
            console.log(id);
            console.log(this.subject);
            console.log(this.group);
            this.table = false;
            this.detail_active = true;
            // this.table = false;
            axios.post('http://127.0.0.1:8000/api/getLessonMarks', {date_visit:id, subject:this.subject, group:this.group[0], symbol:this.group[1]})
                  .then((response) => {               
                       
                        this.lessons = response.data;
                        console.log(this.lessons);
                        // this.detail = response.data;
                        // this.mark = 15;
                        // this.detail_active = true;                                               
                  }).catch(error => {
                      console.log(error);
                  })
          },
          setLesson(){
            console.log(this.dateLesson);
            console.log(this.homework);
             console.log(this.subject);
              console.log(this.group);
            axios.post('http://127.0.0.1:8000/api/setLesson', {
              date_visit:this.dateLesson, 
              homework:this.homework,
              subject_name: this.subject,
              group: this.group
             })
              .then((response) => {
                console.log(response);                     

                }).catch(error => {
                      console.log(error);
                })
            
          },
          
          setCol(){
            this.marks[0].marks.push("");
            this.date.push(""); 
            console.log(this.marks);
          },
          sendMark(id){
            console.log(id);
            let value = document.getElementById(id);
            console.log(value.value);
            let mark = value.value;         
              axios.post('http://127.0.0.1:8000/api/updateVisit', {id_visit:id,visit:mark})
              .then((response) => {
                console.log(response);                     

                }).catch(error => {
                      console.log(error);
                })
            

          },
          setNewMark(id){
            console.log(id);
            let value = document.getElementById(id);
            console.log(value.value);
            let mark = value.value;         
              axios.post('http://127.0.0.1:8000/api/updateMark', {id_mark:id, mark:mark})
              .then((response) => {
                console.log(response);                     

                }).catch(error => {
                      console.log(error);
                })
            

          },
          sendMarkType(id){
            console.log(id);
            let value = document.getElementById(id);
            console.log(value.value);
            let mark = value.value;         
              axios.post('http://127.0.0.1:8000/api/updateMarkType', {id_mark:id, mark_type:mark}) 
              .then((response) => {
                console.log(response);                     

                }).catch(error => {
                      console.log(error);
                })
          },
          sendVisit(id){
            console.log(id);
            let value = document.getElementById(id);
            console.log(value.value);
            let visit = value.value;
              axios.post('http://127.0.0.1:8000/api/updateVisit', {id_visit:id, visit:visit})
              .then((response) => {
                console.log(response);                     

                }).catch(error => {
                      console.log(error);
                })

          },
          setMark(n, increment, qvr){
            let element = 0;
            for(let i = 0; i < this.marks[n].marks.length; i++){
              if(this.marks[n].date_visit[i] == qvr){
                element = this.marks[n].marks[i]
                return element;
              }
            }
            if(element == 0){
              return "";
            }
            
                        
          },
          setId(n, date){
            let element = 0;
            for(let i = 0; i < this.marks[n].marks.length; i++){
              if(this.marks[n].date_visit[i] == date){
                element = this.marks[n].id_mark[i]
                return element;
              }
            }
            
            if(element == 0){
              let str = date + "," + this.marks[n].student_surname;
              return str;
            }
          },
          setNewId(n, date){
            console.log(date);
            console.log(date.marks[0]);
            if(date.marks[0] == undefined){
              let str = date.date_visit[0] + "," + date.student_surname;
              console.log(str)
              return str;
            }
            else{
              return date.id_mark[0];
            }
            // for(let i = 0; i < this.marks[n].marks.length; i++){
            //   if(this.marks[n].date_visit[i] == date){
            //     element = this.marks[n].id_mark[i]
            //     return element;
            //   }
            // }
            
            // if(element == 0){
            //   let str = date.date_visit + "," + this.marks[n].student_surname;
            //   return str;
            // }
          },
          setNewMarks(n, date){
            let element = 0;
            for(let i = 0; i < this.marks[n].marks.length; i++){
              if(this.marks[n].date_visit[i] == date){
                element = this.marks[n].mark[0]
                return element;
              }
            }
            
            if(element == 0){
              let str = date.date_visit + "," + this.marks[n].student_surname;
              return str;
            }
          },
          getAllSubjects() {

            axios.get('http://127.0.0.1:8000/api/getTeacherClasses')
              .then((response) => {
                console.log(response);
                //for (let i = 0; i < response.data.length; i++) {
                      this.menu = response.data;
                      
                      console.log(this.menu);
                //}                         
                }).catch(error => {
                      console.log(error.response.data.message);
                })
          },
          getMarks(subject){
            let username = "Илья";
            let arr = new Map();
            this.subject = subject;
            let connect = "";
            if(this.start_date != ""){
              connect = 'http://127.0.0.1:8000/api/dateMarks';
            }
            else{
              connect = 'http://127.0.0.1:8000/api/subjectsMark';
            }
            axios.post(connect, { username:username, subject:subject, start_date:this.start_date, end_date:this.end_date})
                  .then((response) => {
                        this.mark = 1;
                        this.average = 0;
                        console.log(response);
                        this.marks = response.data;
                        // this.averageMark();
                        this.weightedMark();                                                
                  }).catch(error => {
                      console.log(error);
                      this.mark = 0;
                  })
          },
          getAllStudent(group){
            axios.post('http://127.0.0.1:8000/api/getAllStudents' , {group:group[0], symbol:group[1]})
              .then((response) => {
                console.log(response);
                //for (let i = 0; i < response.data.length; i++) {
                      this.students = response.data;                      
                      console.log(this.students);
                      
                //}                         
                }).catch(error => {
                      console.log(error);
                })
          },
          getMarkTable(subject, group){

            console.log(subject); console.log(group);
            if(this.isActive){
              this.isActive.style.textDecoration = 'none';
            }
            let id = document.getElementById(subject + group);
            this.isActive = id;
            id.style.textDecoration = 'underline';
            this.detail_active = false;
            // getMarkTable
             this.getAllStudent(group);
             axios.post('http://127.0.0.1:8000/api/getMarkTable', { subject:subject, group:group[0], symbol:group[1], quarter:this.chast, year:this.year})
                  .then((response) => {
                        console.log(response);
                        this.subject = subject;
                        this.group = group;
                        this.date = response.data;
                        this.table = true;
                        this.checked = true;
                        
  
                        // console.log(this.table)

                        // this.averageMark();
                        //this.weightedMark();                                                
                  }).catch(error => {
                      console.log(error);
                      this.mark = 0;
                  })
          }, 
          getTeacherTable(subject, group){
            console.log(subject); console.log(group);
             this.getAllStudent(group);
             axios.post('http://127.0.0.1:8000/api/getTeacherTable', { subject:subject, group:group[0], symbol:group[1], quarter:this.chast, year:this.year})
                  .then((response) => {
                        console.log(response);
                        this.marks = response.data;
                        console.log(this.marks);
                        // this.marks = response.data;
                        // this.table = true;
                        // this.mark = 1;
                        // console.log(this.table)
                        // this.averageMark();
                        //this.weightedMark();                                                
                  }).catch(error => {
                      console.log(error);
                      this.mark = 0;
                  })
          },
          averageMark(){
            this.average = 0;
            let count = 0;
            for(let elem in this.marks){
                this.average += Number(this.marks[elem]);
                count++;
            }
            this.average = (this.average / count).toFixed(2);      
          },

          weightedMark(){
            let username = "Илья";
            this.weight = 0;
            this.average = 0;
            axios.post('http://127.0.0.1:8000/api/subjectsWeight', {username:username,subject:this.subject})
                  .then((response) => {
                      console.log(response.data);
                      let n = 0;
                      for(let i = 0; i < response.data.length;i++){
                          this.average += Number(response.data[i].mark);
                      }
                      this.average = (this.average / response.data.length).toFixed(2);

                      for(let i = 0; i < response.data.length; i++){
                        if(response.data[i].mark_type == 'у/р'){
                          n++;
                          this.weight += Number(response.data[i].mark)
                        }
                        else{
                          this.weight += Number(response.data[i].mark) * 10;
                          n += 10;
                        } 
                      }
                      this.weight = (this.weight / n).toFixed(2);                                                
                  }).catch(error => {
                      console.log(error);
            })               
          },
          getHref(elem){
          return "#" + elem;
        }

          

      },
      // computed: {

      // },
      mounted() {
          // this.showMarks(this.menu[0].id, this.menu[0].marks);
          this.getAllSubjects();
          this.getTeacherTable('Алгебра', '7б');
      },
      watch: {
  showModal(val) {
    $(this.$refs.modal).modal(val ? 'show' : 'hide');
  },
},
  
  }
  </script>
  <style scoped>
  .active{
    text-decoration: underline;
  }
    .p-flex{
      font-weight: bold;
      margin-right: 1vw;
    }
    .form-control{
        width: 5vw;
        text-align: center;
    }
    table{
        width: 30%;
        border-width: 1px;
        margin-top: 1vw;
       
    }
    tr,td,th{
        border-width: 1px;
    }
    .mark-table{
        margin-left: 5vw;
        width: 100%;
    }
   .list-group{
    width: 15vw;
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
        margin-top: 1vw;
        cursor: pointer;
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