<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'], ['resources/sass/app.scss'], ['resources/files'])
    <title>Control Study</title>
</head>
<body>
    <div id="app" class="main_div">
        <!-- <v-header></v-header> -->
        <router-view></router-view>
    </div>
</body>
<style>

</style>
</html>