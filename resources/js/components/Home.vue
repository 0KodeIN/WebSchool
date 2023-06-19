<template>
<v-header></v-header>
<div class="card w-50 center mt-3" style="margin-left: 22vw;" v-for="elem in table">
  <div class="card-header">
    {{ elem.header }}
  </div>
  <div class="card-body">
    <!-- <h5 class="card-title">Special title treatment</h5> -->
    <p class="card-text">{{ elem.content }}</p>
  </div>
</div>
</template>
<style >
 

</style>
    
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
            getPost(){
                axios.get('http://127.0.0.1:8000/api/getPosts')
                        .then((response) => {
                            console.log(response);
                            this.table = response.data
                            // console.log(this.table[0].week_day);
                            // for(let i = 0; i < this.table.length; i++){
                            //         this.table.push(response.data[i])
    
                            // }
                            console.log(this.table);
                            // window.location.replace(response.data);
                        }).catch(error=>{
                            console.log(error.response);
                        })

            }
        },
        mounted() {
            this.getPost();
        },
     
    }
</script>