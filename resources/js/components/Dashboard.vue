<template>
    <!-- <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header> -->
<v-header></v-header>
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse mt-10" style="position: static;">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="#" @click="getChart(1)" id="1">
              <span data-feather="home"></span>
              Средняя оценка
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" @click="getChart(2)" id="2">
              <span data-feather="file"></span>
              Рейтинг учеников
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"  @click="getTeacherRating" id="3">
              <span data-feather="shopping-cart"></span>
              Рейтинг учителей
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#"  @click="getChart(4)" id="4">
              <span data-feather="shopping-cart"></span>
              Посещаемость
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="users"></span>
              
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="bar-chart-2"></span>
              Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="layers"></span>
              Integrations
            </a>
          </li> -->
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Сохраненные отчёты</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Текущий месяц
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Текущий год
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Прошлые отчёты
            </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">
              <span data-feather="file-text"></span>
              Year-end sale
            </a>
          </li> -->
        </ul>
      </div>
    </nav>
    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <!-- <h1 class="h2 mt-1">Средняя оценка</h1> -->
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        
        <!-- <div class="btn-toolbar mb-2 mb-md-0 w-50"> -->
          <label for="inputState" class="form-label">Класс</label>
        <select id="inputState" class="form-select w-25 m-2" aria-label="Default select example" v-model="numberClass">
            <option v-for="item in class">{{ item }}</option>
            <!-- <option value="2">Two</option>
            <option value="3">Three</option> -->
        </select>
        <label for="inputState2" class="form-label">Предмет</label>
        <select id="inputState2" class="form-select w-25 m-2" aria-label="Default select example" v-model="subject">
            <option v-for="item in subjects">{{ item.subject_name }}</option>
            <!-- <option value="2">Two</option>
            <option value="3">Three</option> -->
        </select>           

          <select class="form-select w-25 m-2" aria-label="Default select example" >
            <option selected>Период</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
        <button type="button" class="btn btn-sm btn-outline-secondary me-1" @click="updateDashboard">Сформировать</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" @click="downloadXlsx">Скачать</button>
        <div class="btn-group me-2">
            
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
          </div>
        <!-- </div> -->
      </div>

      <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380">
       
      </canvas> -->
      <Bar v-if="loaded" style="padding: 30px;"
                      id="my-chart-id"
                      :options="ChartOptions"
                      :data="chartData"
                      />
      <Line v-if="loaded" style="padding: 30px;"
                      id="my-chart-id2"
                      :options="ChartOptions"
                      :data="chartData"
                      />
      
      <!-- <h2>Оценки учеников</h2> -->
      <div class="table-responsive" v-if="rating">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Педагоги</th>
              <th scope="col">Прошлая четверть</th>
              <th scope="col">Текущая четверть</th>
              <th scope="col">Добавочный рейтинг</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="elem in tableMark">
              <td>{{ elem.surname }}</td>
              <td>{{ (elem.chet1).toFixed(2) }}</td>
              <td>{{ (elem.chet2).toFixed(2) }}</td>
              <td>{{ elem.rating }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <div class="table-responsive" v-if="activeMark">
        <table class="table table-striped table-sm">
          <thead>
            <!-- <tr>
              <th scope="col">Педагоги</th>
              <th scope="col">Текущая четверть</th>
              <th scope="col">Прошлая четверть</th>
              <th scope="col">Добавочный рейтинг</th>
            </tr> -->
          </thead>
          <tbody>
            <tr v-for="(value, index) in students">
              <td>{{ value }}</td>
              <td v-for="markAll in tableMark[value]">{{ markAll }}</td>
              <!-- <td>{{ (elem.chet1).toFixed(2) }}</td>
              <td>{{ (elem.chet2).toFixed(2) }}</td>
              <td>{{ elem.rating }}</td> -->
            </tr>
          </tbody>
        </table>
      </div>
      <div class="table-responsive" v-if="activeVisit">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Ученики</th>
              <th scope="col">Посещение</th>
              <th scope="col">Отсутсвие</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(value, index) in students">
              <td>{{ students[index] }}</td>
              <td>{{ marks[index]}}</td>
              <td>{{ hight - marks[index]}}</td>
              <!-- <td>{{ (elem.chet1).toFixed(2) }}</td>
              <td>{{ (elem.chet2).toFixed(2) }}</td>
              <td>{{ elem.rating }}</td> -->
            </tr>
          </tbody>
        </table>
      </div>
      
    </main>
  </div>
</div>
</template>
<script>
import { Bar } from 'vue-chartjs';
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, LineElement, PointElement } from 'chart.js';
import axios from 'axios';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, LineElement, PointElement);
export default {
  name: 'BarChart',
  components: { Bar, Line },
  data() {
    return {
      chartData: {
        labels: [  ],
        datasets: [ 
          { 
            label: 'Средняя оценка',
            data: [] ,
            backgroundColor: '#0074d9',
          } 
        ]
      },
      chartOptions: {
        responsive: true
      },
      loaded: false,
      marks: [],
      students: [],
      tableMark: [],
      url: null,
      class: [],
      subjects: [],
      numberClass: null,
      subject: null,
      html: null,
      chartType: 1,
      rating: false,
      activeMark: false,
      activeVisit: false,
      link: false,
      hight: null

    }
  },

  methods:{
    getMarks(){
            let username = "Илья";
            let subject = "Русский язык";
            this.weight = 0;
            this.average = 0;
            this.activeVisit = false;
            axios.post('http://127.0.0.1:8000/api/subjectsWeight', {username:username,subject:subject})
                  .then((response) => {
                      console.log(response.data)
                      for(let i = 0; i < response.data.length; i++){
                        this.chartData.labels.push(i);
                        this.chartData.datasets[0].data.push(Number(response.data[i].mark));
                      }
                      this.loaded = true;
                      // console.log(this.chartData.datasets);
                      

                      // let n = 0;
                      // for(let i = 0; i < response.data.length;i++){
                      //     this.average += Number(response.data[i].mark);
                      // }
                      // this.average = (this.average / response.data.length).toFixed(2);

                      // for(let i = 0; i < response.data.length; i++){
                      //   if(response.data[i].mark_type == 'у/р'){
                      //     n++;
                      //     this.weight += Number(response.data[i].mark)
                      //   }
                      //   else{
                      //     this.weight += Number(response.data[i].mark) * 10;
                      //     n += 10;
                      //   } 
                      // }
                      // this.weight = (this.weight / n).toFixed(2);                                                
                  }).catch(error => {
                      console.log(error);
            })
    },
    getAvgMark(){
            // let group = 7;
            // let symbol = 'а'
            // let subject = 'Русский язык';
            this.loaded = false;
            this.rating = false
            axios.post('http://127.0.0.1:8000/api/subjectsAvg', 
            {
              group:this.numberClass[0],
              symbol:this.numberClass[1],
              subject: this.subject
            })
                  .then((response) => {
                      console.log(response.data);
                      
                      
                      this.students = [];
                      this.marks = [];
                      this.tableMark = [];
                      let sum = 0; let j = 0;
                      this.loaded = false;
                      this.tableMark = response.data;
                      
                      for(let elem in response.data){
                        for(let i = 0; i < response.data[elem].length;i++){
                          sum += Number(response.data[elem][i]);
                        }
                        this.students[j] = elem;
                        sum = sum / response.data[elem].length;
                        this.marks[j] = sum.toFixed(2);
                        sum = 0;
                        j++;
                      }
                      console.log(this.students);
                      console.log(this.marks);
                      console.log(this.subject);
                      this.chartData.labels = this.students;
                     
                      this.chartData.datasets[0].data = this.marks;
                      this.chartData.datasets[0].label = 'Средняя оценка'
                      this.loaded = true;
                      this.activeMark = true;
                      // let n = 0;
                      // for(let i = 0; i < response.data.length;i++){
                      //     this.average += Number(response.data[i].mark);
                      // }
                      // this.average = (this.average / response.data.length).toFixed(2);

                      // for(let i = 0; i < response.data.length; i++){
                      //   if(response.data[i].mark_type == 'у/р'){
                      //     n++;
                      //     this.weight += Number(response.data[i].mark)
                      //   }
                      //   else{
                      //     this.weight += Number(response.data[i].mark) * 10;
                      //     n += 10;
                      //   } 
                      // }
                      // this.weight = (this.weight / n).toFixed(2);                                                
                  }).catch(error => {
                      console.log(error);
            })               
          },
          getVisit(){
            // let group = 7;
            // let symbol = 'а'
            // let subject = 'Русский язык';
            this.loaded = false;
            this.rating = false
            axios.post('http://127.0.0.1:8000/api/getVisitDashboard', 
            {
              group:this.numberClass[0],
              symbol:this.numberClass[1],
              subject: this.subject
            })
                  .then((response) => {
                      console.log(response.data);
                      
                      
                      this.students = [];
                      this.marks = [];
                      this.tableMark = [];
                     let j = 0;
                      for(let i = 1; i < response.data.length; i++){
                        this.marks[j] = response.data[i].count;
                        j++; 
                      }
                      j = 0;
                      for(let i = 1; i < response.data.length; i++){
                        this.students[j] = response.data[i].name
                        j++;
                      }
                      let newArr = [];
                      for(let i = 0; i < (response.data.length - 1); i++){
                        newArr[i] = response.data[0].count;
                      }
                      // console.log(newArr);
                      // let sum = 0; let j = 0;
                      // this.loaded = false;
                      // this.tableMark = response.data;
                      
                      // for(let elem in response.data){
                      //   for(let i = 0; i < response.data[elem].length;i++){
                      //     sum += Number(response.data[elem][i]);
                      //   }
                      //   this.students[j] = elem;
                      //   sum = sum / response.data[elem].length;
                      //   this.marks[j] = sum.toFixed(2);
                      //   sum = 0;
                      //   j++;
                      // }
                      // console.log(this.students);
                      // console.log(this.marks);
                      // console.log(this.subject);
                      this.chartData.labels = this.students;
                     
                      this.chartData.datasets[0].data = this.marks;
                      this.chartData.datasets[0].label = 'Посещение'
                      this.chartData.datasets[1] = [ 
                        { 
                        label: '',
                        data: [],
                        backgroundColor: '',
                        } 
                      ];
                      this.chartData.datasets[1].label = 'Всего';
                      // this.chartData.datasets[1].data = newArr;
                      this.chartData.datasets[1].data = newArr;
                      this.chartData.datasets[1].backgroundColor = 'black';
                      this.hight = newArr[0];


                      
                      console.log(this.chartData);
                      // this.chartData.datasets[1].labels = (16,16,16,16,16,16,16,16);
                      this.loaded = true;
                      this.activeVisit = true;
                      // let n = 0;
                      // for(let i = 0; i < response.data.length;i++){
                      //     this.average += Number(response.data[i].mark);
                      // }
                      // this.average = (this.average / response.data.length).toFixed(2);

                      // for(let i = 0; i < response.data.length; i++){
                      //   if(response.data[i].mark_type == 'у/р'){
                      //     n++;
                      //     this.weight += Number(response.data[i].mark)
                      //   }
                      //   else{
                      //     this.weight += Number(response.data[i].mark) * 10;
                      //     n += 10;
                      //   } 
                      // }
                      // this.weight = (this.weight / n).toFixed(2);                                                
                  }).catch(error => {
                      console.log(error);
            })               
          },
          getTeacherRating(){
            // let group = 7;
            // let symbol = 'а'
            // let subject = 'Русский язык';
            this.loaded = false;
            axios.get('http://127.0.0.1:8000/api/getTeacherRating')
                  .then((response) => {
                      console.log(response.data);
                      if(this.link){
                        this.link.style.color = 'black';
                      }
                      this.link = document.getElementById('3');
                      this.link.style.color = 'blue';
                      this.activeMark = false;
                      this.students = [];
                      this.marks = [];
                      let sum = 0; let j = 0;
                      this.loaded = false;
                      this.tableMark = response.data;
                      let arr = [];
                      
                      for(let elem in response.data){
                        let value = response.data[elem].chet2 + response.data[elem].rating;
                        console.log(elem);
                        // arr.push(value)
                        // for(let i = 0; i < response.data[elem].length;i++){
                        //   sum += Number(response.data[elem][i]);
                        // }
                        this.students[j] = response.data[elem].surname;
                        this.marks[j] = value;
                        j++;
                      }
                      console.log(this.students);
                      console.log(this.marks);
                      console.log(this.subject);
                      this.chartData.labels = this.students;
                     
                      this.chartData.datasets[0].data = this.marks;
                      this.chartData.datasets[0].label = 'Рейтинг'
                      // this.chartData.datasets[1].data = this.marks;
                      this.loaded = true;
                      this.rating = true;                                               
                  }).catch(error => {
                      console.log(error);
            })               
          },
          weightedMark(){
            this.loaded = false;
            this.rating = false;
            axios.post('http://127.0.0.1:8000/api/dashboardWeight', 
            {
              group:this.numberClass[0],
              symbol:this.numberClass[1],
              subject: this.subject
            })
                  .then((response) => {
                      // console.log(response.data);
                      
                      console.log(response.data);
                      this.students = [];
                      this.marks = [];
                      // this.students = [];
                      // this.marks = [];
                      // let sum = 0; let j = 0;
                      // this.loaded = false;
                      this.tableMark = response.data;
                      let j = 0;
                      for(let elem in response.data){
                        let average = null;
                        let weight = null;
                        let n = null;
                        let values = [];
                        let str = '';
                        for(let i = 0; i < response.data[elem].length; i++){
                          str = response.data[elem][i];
                          values = String(str).split(' ');
                          weight += (Number(values[0]) * Number(values[1]));
                          n += Number(values[1]);
                        }
                        this.students[j] = elem;
                        //  console.log((weight/n).toFixed(2));
                          weight = Number((weight / n)).toFixed(2);
                        this.marks[j] = weight;
                        j++;
                        n = 0;
                      }
                      this.chartData.labels = this.students;
                     
                      this.chartData.datasets[0].data = this.marks;
                      this.chartData.datasets[0].label = 'Рейтинг'
                      this.loaded = true;
                      this.activeMark = true;
                      // console.log(this.marks);
                        // this.students[j] = elem;
                        // sum = sum / response.data[elem].length;
                        // this.marks[j] = sum.toFixed(2);
                        // sum = 0;
                        // j++;
                      
                      // console.log(this.students);
                      // console.log(this.marks);
                      // console.log(this.subject);
                      // this.chartData.labels = this.students;
                     
                      // this.chartData.datasets[0].data = this.marks;
                      // this.loaded = true;
                      // let n = 0;
                      // for(let i = 0; i < response.data.length;i++){
                      //     this.average += Number(response.data[i].mark);
                      // }
                      // this.average = (this.average / response.data.length).toFixed(2);

                      // for(let i = 0; i < response.data.length; i++){
                      //   if(response.data[i].mark_type == 'у/р'){
                      //     n++;
                      //     this.weight += Number(response.data[i].mark)
                      //   }
                      //   else{
                      //     this.weight += Number(response.data[i].mark) * 10;
                      //     n += 10;
                      //   } 
                      // }
                      // this.weight = (this.weight / n).toFixed(2);                                                
                  }).catch(error => {
                      console.log(error);
                      
                      
                    })               
          },
    downloadXlsx(){
      // http://127.0.0.1:8000/api/export
      axios.get('http://127.0.0.1:8000/api/export') 
        .then((response) => {
          console.log(response.data);
          window.location.replace(response.data);
                                             
        }).catch(error => {
          console.log(error);
        })               
    },
    getClass(){
      axios.get('http://127.0.0.1:8000/api/allClass') 
        .then((response) => {
          console.log(response.data);
          this.class = response.data;
                                             
        }).catch(error => {
          console.log(error);
        }) 
    },
    getSubjects(){
      axios.get('http://127.0.0.1:8000/api/getAllSubjects') 
        .then((response) => {
          console.log(response.data);
          this.subjects = response.data;
                                             
        }).catch(error => {
          console.log(error);
        }) 
    },
    updateDashboard(){
      this.loaded = false;
      this.activeMark = false;
      this.rating = false;
      if(this.chartType == 2){
        this.weightedMark();
      }
      if(this.chartType == 1){
        this.getAvgMark();
      }
      if(this.chartType == 4){
        this.getVisit();
      }
    },
    getChart(elem){
      this.loaded = false;
      this.activeMark = false;
      this.rating = false;
      this.chartType = elem;
      if(this.link){
        this.link.style.color = 'black';
      }
      this.link = document.getElementById(elem);
      this.link.style.color = 'blue';
      
    }
  },
  mounted() {
    // this.getMarks();
    // this.getAvgMark();
    this.getClass();
    this.getSubjects();
  },
  computed: {
    chartData(){
      // this.chartData.labels = this.students;
      // this.chartData.datasets[0].data = this.marks;
      console.log(this.chartData);
      return this.chartData;
    },
    ChartOptions(){
      
      return this.chartOptions;
    }
  }

}
</script>
<style scoped>
    header{
      margin-bottom: 0;
    }

    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      body {
  font-size: .875rem;
}

.feather {
  width: 16px;
  height: 16px;
  vertical-align: text-bottom;
}

/*
 * Sidebar
 */

.sidebar {
  position: fixed;
  top: 0;
  /* rtl:raw:
  right: 0;
  */
  bottom: 0;
  /* rtl:remove */
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 48px 0 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

@media (max-width: 767.98px) {
  .sidebar {
    top: 5rem;
  }
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #727272;
}

.sidebar .nav-link.active {
  color: #2470dc;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}

/*
 * Navbar
 */

.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: 1rem;
  background-color: rgba(0, 0, 0, .25);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .navbar-toggler {
  top: .25rem;
  right: 1rem;
}

.navbar .form-control {
  padding: .75rem 1rem;
  border-width: 0;
  border-radius: 0;
}

.form-control-dark {
  color: #fff;
  background-color: rgba(255, 255, 255, .1);
  border-color: rgba(255, 255, 255, .1);
}

.form-control-dark:focus {
  border-color: transparent;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
}

</style>
