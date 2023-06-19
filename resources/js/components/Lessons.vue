<template>

    <v-header></v-header>
    <div class="modal fade" id="litModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Литература по предмету</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3" v-for="elem in books">
          <label for="exampleInputEmail1" class="form-label">{{elem.lit_name}}</label>
          <a for="exampleInputEmail1" v-bind:href="elem.lit_url" class="form-label ms-2">{{elem.lit_url}}</a>
        </div>        
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
    <div class="d-flex justify-content-start">
      <ul class="list-group">
        <li class="list-group-item m-0" v-bind:id=elem.id_subject v-for="elem in menu" @click="getLessons(elem.id_subject)">{{ elem.subject_name }}</li>
      </ul>
      <div v-if="detail_active" style="margin-left: 7vw;">
        <button class = "btn btn-primary ms-2" @click ="showLiterature()">Литература</button>
  <table class="table w-100" style="text-align: center;">
  <thead>
    <tr>
      <th scope="col w-25">Дата занятия</th>
      <th scope="col w-25">Домашнее задание</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="value in lessons">
      <td>{{ value.date_visit }}</td>
      <td>{{value.homework}}</td>
    </tr>
  </tbody>
  
 

</table>

</div> 
    <div class="mark-table" v-if="mark==1">
      <div class="d-flex " style="width: 45vw; align-items: center;">
          <span>Год </span>
          <input type="text" class="form-control ms-2" v-model="year">
          <span style="margin-left: 1vw;">Четверть </span>
          <input type="number" min="1" max="4" class="form-control ms-2" v-model="chet">
          <span style="margin-left: 1vw;">С </span>
          <input type="date" class="form ms-2" id="start" name="trip-start"
          
          min="2019-09-01" max="2023-05-31" v-model="start_date">
            <span style="margin-left: 1vw;">По </span>
            <input type="date" class="form ms-2" id="start" name="trip-start"
            
            min="2019-09-01" max="2023-05-31" v-model="end_date">
            <button class="btn btn-primary ms-2" @click="getMarks(this.subject)">Фильтровать</button>
      </div>
        
    
 
  <table class="table" style="width: 10vw;" v-if="mark==1">
  <thead>
    <tr>
      <th scope="col" v-bind:id="elem" style="text-align: center; cursor: pointer;" v-for="elem in Object.keys(marks)" @click="detailLesson(elem)">{{elem.replace('2022-','')}}</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td v-for="elem in marks"><input type="text" v-bind:value="elem" class="form-control"  readonly></td>
    </tr>
  </tbody>
  

</table>
<div  v-if="mark==1">
<div class="d-flex">
    <p class="p-flex">Средний балл </p>
  <span>{{ this.average }}</span>
  </div>
  <div class="d-flex">
    <p class="p-flex">Рейтинг </p>
  <span>{{ this.weight }}</span>
  </div>
  <div class="d-flex" v-if="this.five_forecast">
    <p class="p-flex">{{ this.five_string }}</p>
  <span>{{ this.five_forecast }}</span>
  </div>
  <div class="d-flex" v-if="this.four_forecast">
    <p class="p-flex">{{ this.four_string }}</p>
  <span>{{ this.four_forecast }}</span>
  </div>
</div>
    </div>
    </div>
    <p v-if="mark==0">Нет данных</p>
    <!-- <div>
        <section class="marks">
          <ul class="menu">
            <li :id=elem.id v-for="elem in menu"  class="head_mark">{{ elem.subject_name }}</li>
          </ul>
        <div class="table-marks">{{ subject }}</div>
        </section>        
    </div> -->
    
     



     
  </template>
  <script>
      export default{
    
      data(){
          return{
              menu: [
                  { id_subject: "", subject_name: ""},
              ],
              marks: [
                {date_visit:"",mark:[]}
              ],  
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
              marks_forecast: [],
              five_forecast: null,
              four_forecast: null,
              four_string: '',
              five_string: '',
              detail: [],
              detail_active: false,
              year: '',
              chet: '',
              lessons: [],
              books: [],
              activeElement: false
              
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
          showLiterature(){
            this.checked = false;
            this.lit = true;
            let modalLit = new Modal(document.getElementById('litModal'));
            modalLit.show();
            this.getFiles();

          },
          getFiles(){
            console.log(this.subject);
                    axios.post('http://127.0.0.1:8000/api/getLit',{id:10002})
                        .then((response) => {
                            console.log(response);
                            this.books = response.data;
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                
            },
          forecast(sum, count){
            console.log(sum);
            console.log(count);
            // count = 8;
            let cast = 0;
            if((sum/count)>3.5 && (sum/count)<4.5) {
              cast = ((4.5  * count) - sum)/0.5;
              this.five_forecast = Math.ceil(cast);
              this.five_string = "Необходимое количество оценок 5 до оценки 5 = ";
              console.log(cast);
            }
            if((sum/count)>2.5 && (sum/count)<3.5) {
              cast = ((3.5  * count) - sum)/0.5;
              this.four_forecast = Math.ceil(cast);
              this.four_string = "Необходимое количество оценок 5 до оценки 4 = ";
              cast = ((3.5  * count) - sum)/1.5;
              this.five_forecast = Math.ceil(cast);
              this.five_string = "Необходимое количество оценок 4 до оценки 4 = ";
              console.log(this.four_forecast);
              console.log(this.five_forecast);
            }
            // if((sum/count)>2.5 && (sum/count)<3.5) {
            //   let cast = (3.5 * 2 * count)/sum;
            //   this.five_forecast = cast;
            //   console.log(cast);
            // }

          }, 
          getAllSubjects() {

            axios.get('http://127.0.0.1:8000/api/subjects')
              .then((response) => {
                console.log(response);
                for (let i = 0; i < response.data.length; i++) {
                      this.menu[i] = response.data[i];
                      this.detail_active = true;
                }                         
                }).catch(error => {
                      alert(error);
                })
          },
          getMarks(subject){
            let username = "Илья";
            let arr = new Map();
            this.subject = subject;
            let connect = "";
            this.detail_active = false;
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
          getLessons(subject){
            console.log(subject);
            if(this.activeElement){
                this.activeElement.style.color = 'black';
            }
            this.activeElement = document.getElementById(subject);
            this.activeElement.style.color = 'Blue';
            console.log(this.activeElement);
            axios.post('http://127.0.0.1:8000/api/getLessons', { id_class:101, id_subject:subject})
                  .then((response) => {
                    this.lessons = response.data;
                    console.log(response);
                                                 
                  }).catch(error => {
                      console.log(error);
                      this.mark = 0;
                  })
          },
          detailLesson(id){
            let surname = 'Шапкин';
            // let subject = 'Русский язык';
            axios.post('http://127.0.0.1:8000/api/detailMark', { surname:surname, subject:this.subject, date_visit:id})
                  .then((response) => {               
                        console.log(response);
                        this.detail = response.data;
                        this.mark = 15;
                        this.detail_active = true;                                               
                  }).catch(error => {
                      console.log(error);
                  })
          },
          returnMark(){
            this.detail = [];
            this.detail_active = false;
            this.mark = 1;
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
                      this.marks_forecast = response.data;
                      let n = 0;
                      for(let i = 0; i < response.data.length;i++){
                          this.average += Number(response.data[i].mark);
                      }
                      this.forecast(this.average, response.data.length);
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

          

      },
      mounted() {
          this.showMarks(this.menu[0].id, this.menu[0].marks);
          this.getAllSubjects();
      },
  
  }
  </script>
  <style scoped>
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