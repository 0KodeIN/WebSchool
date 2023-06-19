<template>
    <v-header></v-header>
    <div class="form-file form-file-sm ms-5 mb-2">
  
  <!-- <label class="form-file-label" for="customFileSm">
    <span class="form-file-text">Загрузите файл с расписанием</span>
    <span class="form-file-button">Browse</span>
  </label> -->
  <input type="file" class="form-file-input" id="customFileSm" ref="file" @change="handleFileUpload()">
  <button class="btn btn-primary" @click="submitFile()">Загрузить</button>
  <button class="btn btn-primary ms-2" @click="setTimeTable()">Добавить запись</button>
</div>
    <ul class="list-group">
      <div class="d-flex ms-2 align-items-center" v-for="elem in table">
        <li class="list-group-item m-0 align-items-center mt-2" v-bind:id=elem.tid_timetable >
            {{ elem.week_day + " " + elem.subject_name + " " + elem.group + elem.symbol + " " + elem.lesson_time + " " + elem.teacher_surname}}
        </li>
        <button type="button" class="btn-close ms-2" aria-label="Close" width="30" height="30" @click="deleteRow(elem.tid_timetable)"></button>
      </div>
             

      </ul>
      <div class="modal fade" id="newModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="checked">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ошибка</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Дата занятия</label>
    <input type="date" class="form ms-2" id="start" name="trip-start"
          
          min="2019-09-01" max="2023-05-31" >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Домашнее задание</label>
    <textarea id="w3review" name="w3review" rows="4" cols="50" >

</textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="setTimeTable()">Добавить</button>
      </div>
    </div>
  </div>
</div>
</template>
<style></style>
<script>
    export default {
        data() {
            return {
                table: [],
                checked: false,
                deletedId: 0,
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
                            location.reload();
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

            }
        },
        mounted() {
            this.getTable();
        },
        watch: {
  showModal(val) {
    $(this.$refs.modal).modal(val ? 'show' : 'hide');
  },
},
    }
</script>