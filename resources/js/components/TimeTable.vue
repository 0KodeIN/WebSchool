<template>
     <v-header></v-header>
     
<div class="container mt-5">

                
    <div class="d-flex">
        <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Время</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in monday">
                                <td class="align-middle">
                                    <span>{{ elem.lesson_time}}</span>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Понедельник</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in monday">
                                <td class="align-middle">
                                    <div class="table-content">
                                        <p>{{ elem.subject_name}}</p>
                                        <p>{{ elem.teacher_surname}}</p>
                                        <p>{{ elem.class_id}} Кабинет</p> 
                                    </div>                                  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Вторник</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in tuesday">
                                <td class="align-middle">
                                    <div class="table-content">
                                        <p>{{ elem.subject_name}}</p>
                                        <p>{{ elem.teacher_surname}}</p>
                                        <p>{{ elem.class_id}} Кабинет</p> 
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Среда</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in wednesday">
                                <td class="align-middle">
                                    <div class="table-content">
                                        <p>{{ elem.subject_name}}</p>
                                        <p>{{ elem.teacher_surname}}</p>
                                        <p>{{ elem.class_id}} Кабинет</p> 
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Четверг</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in thursday">
                                <td class="align-middle">
                                    <div class="table-content">
                                        <p>{{ elem.subject_name}}</p>
                                        <p>{{ elem.teacher_surname}}</p>
                                        <p>{{ elem.class_id}} Кабинет</p> 
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Пятница</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="elem in friday">
                                <td class="align-middle">
                                    <div class="table-content">
                                        <p>{{ elem.subject_name}}</p>
                                        <p>{{ elem.teacher_surname}}</p>
                                        <p>{{ elem.class_id}} Кабинет</p> 
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
    </div>
    <div class="table-responsive">
                    
                    <!-- <table class="table table-bordered text-center">
                        <thead>
                            <tr class="bg-light-gray">
                                <th class="text-uppercase">Время
                                </th>
                                <th class="text-uppercase">Понедельник</th>
                                <th class="text-uppercase">Вторник</th>
                                <th class="text-uppercase">Среда</th>
                                <th class="text-uppercase">Четверг</th>
                                <th class="text-uppercase">Пятница</th>
                            </tr>
                        </thead> -->
                        <!-- <tbody>
                            <tr v-for="elem in monday">
                                <td class="align-middle">{{ this.monday[0].teacher_surname}}</td>
                                <td class="align-middle">{{ this.tuesday[0].teacher_surname}}</td>
                                <td class="align-middle">{{ this.wednesday[0].teacher_surname}}</td>
                                <td class="align-middle">{{ this.thursday[0].teacher_surname}}</td>
                                <td class="align-middle">{{ this.friday[0].teacher_surname}}</td> -->
                                <!-- <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Dance</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Yoga</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Marta Healy</div>
                                </td>

                                <td>
                                    <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Music</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Dance</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Art</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Kate Alley</div>
                                </td> -->
                            <!-- </tr> -->
                            <!-- <tr v-for="elem in monday"> -->
                                <!-- <td class="align-middle"></td> -->
                                <!-- <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Dance</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Yoga</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Marta Healy</div>
                                </td>

                                <td>
                                    <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Music</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Dance</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Art</span>
                                    <div class="margin-10px-top font-size14">9:00-10:00</div>
                                    <div class="font-size13 text-light-gray">Kate Alley</div>
                                </td> -->
                            <!-- </tr> -->

                            <!-- <tr>
                                <td class="align-middle">10:00am</td>
                                <td>
                                    <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Music</span>
                                    <div class="margin-10px-top font-size14">10:00-11:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td class="bg-light-gray">

                                </td>
                                <td>
                                    <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Art</span>
                                    <div class="margin-10px-top font-size14">10:00-11:00</div>
                                    <div class="font-size13 text-light-gray">Kate Alley</div>
                                </td>
                                <td>
                                    <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Yoga</span>
                                    <div class="margin-10px-top font-size14">10:00-11:00</div>
                                    <div class="font-size13 text-light-gray">Marta Healy</div>
                                </td>
                                <td>
                                    <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">English</span>
                                    <div class="margin-10px-top font-size14">10:00-11:00</div>
                                    <div class="font-size13 text-light-gray">James Smith</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-middle">11:00am</td>
                                <td>
                                    <span class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Break</span>
                                    <div class="margin-10px-top font-size14">11:00-12:00</div>
                                </td>
                                <td>
                                    <span class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Break</span>
                                    <div class="margin-10px-top font-size14">11:00-12:00</div>
                                </td>
                                <td>
                                    <span class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Break</span>
                                    <div class="margin-10px-top font-size14">11:00-12:00</div>
                                </td>
                                <td>
                                    <span class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Break</span>
                                    <div class="margin-10px-top font-size14">11:00-12:00</div>
                                </td>
                                <td>
                                    <span class="bg-lightred padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Break</span>
                                    <div class="margin-10px-top font-size14">11:00-12:00</div>
                                </td>
                            </tr>

                            <tr>
                                <td class="align-middle">12:00pm</td>
                                <td class="bg-light-gray">

                                </td>
                                <td>
                                    <span class="bg-purple padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Art</span>
                                    <div class="margin-10px-top font-size14">12:00-1:00</div>
                                    <div class="font-size13 text-light-gray">Kate Alley</div>
                                </td>
                                <td>
                                    <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Dance</span>
                                    <div class="margin-10px-top font-size14">12:00-1:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td>
                                    <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Music</span>
                                    <div class="margin-10px-top font-size14">12:00-1:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td class="bg-light-gray">

                                </td>
                            </tr>

                            <tr>
                                <td class="align-middle">01:00pm</td>
                                <td>
                                    <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">English</span>
                                    <div class="margin-10px-top font-size14">1:00-2:00</div>
                                    <div class="font-size13 text-light-gray">James Smith</div>
                                </td>
                                <td>
                                    <span class="bg-yellow padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Music</span>
                                    <div class="margin-10px-top font-size14">1:00-2:00</div>
                                    <div class="font-size13 text-light-gray">Ivana Wong</div>
                                </td>
                                <td class="bg-light-gray">

                                </td>
                                <td>
                                    <span class="bg-pink padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">English</span>
                                    <div class="margin-10px-top font-size14">1:00-2:00</div>
                                    <div class="font-size13 text-light-gray">James Smith</div>
                                </td>
                                <td>
                                    <span class="bg-green padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16  xs-font-size13">Yoga</span>
                                    <div class="margin-10px-top font-size14">1:00-2:00</div>
                                    <div class="font-size13 text-light-gray">Marta Healy</div>
                                </td>
                            </tr> -->
                        <!-- </tbody> -->
                    <!-- </table> -->
                </div>
            </div>
</template>

<script>
    export default {
        data() {
            return {
                file: null,
                table: [],
                time: [],
                monday: [],
                tuesday: [],
                wednesday: [],
                thursday: [],
                friday: [],
            }
        },
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            submitFile(){
                    const formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('http://127.0.0.1:8000/api/timetable', formData)
                        .then((response) => {
                            console.log(response);
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

                
            },
            getTable(){
                axios.get('http://127.0.0.1:8000/api/table')
                        .then((response) => {
                            console.log(response);
                            this.table = response.data;
                            console.log(this.table[0].week_day);
                            for(let i = 0; i < this.table.length; i++){
                                if(this.table[i].week_day == 'Понедельник'){
                                    this.monday.push(this.table[i])
                                }
                                if(this.table[i].week_day == 'Вторник'){
                                    this.tuesday.push(this.table[i])
                                }
                                if(this.table[i].week_day == 'Среда'){
                                    this.wednesday.push(this.table[i])
                                }
                                if(this.table[i].week_day == 'Четверг'){
                                    this.thursday.push(this.table[i])
                                }
                                if(this.table[i].week_day == 'Пятница'){
                                    this.friday.push(this.table[i])
                                }
                            }
                            console.log(this.monday);
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })
            }
        },
        mounted() {
            this.getTable();
        }
    }
</script>
<style scoped>
.table-content{
    width: 10vw;
}
</style>
