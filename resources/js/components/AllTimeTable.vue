<template>
    <v-header></v-header>
    
    <ul class="list-group w-75 ms-3 mt-3">
        <li class="list-group-item m-0" :id=elem.id v-for="elem in table">
            {{ elem.week_day + " " + elem.subject_name + " " + elem.group + elem.symbol + " " + elem.lesson_time }}
        </li>
      </ul>

</template>
<style></style>
<script>
    export default {
        data() {
            return {
                table: [],
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
            this.getTable();
        }
    }
</script>