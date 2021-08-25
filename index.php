<?php
session_start();
if (isset($_SESSION['ONLINE']) && $_SESSION['ONLINE'] == TRUE){
  header('Location: /Home/Home.php');
}
?>

<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js" integrity="sha512-otOZr2EcknK9a5aa3BbMR9XOjYKtxxscwyRHN6zmdXuRfJ5uApkHB7cz1laWk2g8RKLzV9qv/fl3RPwfCuoxHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
<div id="app">
  <v-form v-model="loginForm">
    <v-container>
      <v-row>
        <v-col>
          <v-text-field
            v-model="username"
            label="Username"
            required
            clearable
          ></v-text-field>
        </v-col>

        <v-col>
          <v-text-field
            v-model="password"
            label="Password"
            required
            clearable
          ></v-text-field>
        </v-col>
      </v-row>
    <div>
    <v-btn
  elevation="2"
  v-model="submit"
  @click="loginRequest"
  >Submit</v-btn>
</div>
    </v-container>
  </v-form>
</div>

</body>

</html>


<script>
   new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  computed: {

  },

  data: () => ({
      loginForm: false,
      username: '',
      password: '',
      data: null,
  }),
  methods: {
    loginRequest(){
    axios.post('/Home/login.php', {
    username: this.username,
    password: this.password,
   }).then(function(response){
    this.data = response.data 
    console.log(this.data)
    window.location.reload();
   });
  },
  },

});
  </script>