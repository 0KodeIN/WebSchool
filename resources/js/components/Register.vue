<template>

    <input v-model="email" type="text" placeholder="email">
    <input v-model="name" type="text" placeholder="name">
    <input v-model="password" type="password">
    <input v-model="password_confirnation" type="password">
    <input @click.prevent = "register" type="submit" value="Register">
    <textarea v-model="content"></textarea>
    </template>
    <style>
        .v-h1{
            font-size: 54px;
        }
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
                password_confirnation: null
            }
        },
        methods: {
            register(){
                console.log(this.email);
                console.log(this.password);
                axios.get('sanctum/csrf-cookie').then((response) => {
                    axios.post('/createuser', {name: this.name, email: this.email, password: this.password, password_confirnation: this.password_confirnation})
                        .then((response) => {
                            console.log(response);
                            
                        })
                })
                
            }
        },
        mounted() {
            //console.log('Component mounted.')
        }
    }
    </script>