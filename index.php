<?php
session_start();
if (isset($_SESSION['ONLINE']) && $_SESSION['ONLINE'] == TRUE){
  header('Location: /View/Home.php');
}
include_once './System/global_var.php';
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
    <v-app>
        <v-dialog v-model="dialog" persistent max-width="600px" min-width="360px">
            <div>
                <v-tabs v-model="tab" show-arrows background-color="dark" icons-and-text dark grow>
                    <v-tab v-for="i in tabs" :key="i">
                        <v-icon large>{{ i.icon }}</v-icon>
                        <div class="caption py-1">{{ i.name }}</div>
                    </v-tab>
                    <v-tab-item>
                      
                        <v-card class="px-4">
                            <v-card-text>
                                <v-form v-model="loginForm" lazy-validation>
                                    <v-row>
                                    <v-col cols="12">
                                    <v-alert
                                    v-model="alertDisplay"
                                    :type="alertType"
                                    dismissible
                                    >
                                    {{alertMessage}}
                                    </v-alert>
                                    </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="usernameLogin" @change="unlockLogin"  label="Username":rules="[rules.required]" outlined  clearable ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="passwordLogin" label="Password" @change="unlockLogin" :rules="[rules.required]":append-icon="showLoginPassword ? 'mdi-eye' : 'mdi-eye-off'"  :type="showLoginPassword ? 'text' : 'password'"  counter @click:append="showLoginPassword = !showLoginPassword" outlined  clearable></v-text-field>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6" xsm="12">
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col class="d-flex" cols="12" sm="3" xsm="12">
                                            <v-btn x-large block :disabled="!loginBtn" color="success" v-model="submitLogin" @click="loginRequest"> Login </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>

                    </v-tab-item>
                    <v-tab-item>

                        <v-card class="px-4">
                            <v-card-text>
                                <v-form  v-model="registerForm" lazy-validation>
                                    <v-row>
                                    <v-col cols="12">
                                    <v-alert
                                    v-model="alertDisplayRegister"
                                    :type="alertTypeRegister"
                                    dismissible
                                    >
                                    {{alertMessageRegister}}
                                    </v-alert>
                                    </v-col>
                                        <v-col cols="12" >
                                            <v-text-field v-model="usernameRegister" label="Username" @change="unlockLoginRegister" :rules="[rules.required]"outlined  clearable ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="emailRegister" label="E-mail" @change="unlockLoginRegister" :rules="[rules.required]" outlined  clearable ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field v-model="passwordRegister" label="Password" @change="unlockLoginRegister" :rules="[rules.required]" :append-icon="showRegisterPassword ? 'mdi-eye' : 'mdi-eye-off'"  :type="showRegisterPassword ? 'text' : 'password'" name="input-10-1"  counter @click:append="showRegisterPassword = !showRegisterPassword" outlined  clearable ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field block v-model="verifyRegister" label="Confirm Password" @change="unlockLoginRegister" :rules="[rules.required]" :append-icon="showRegisterVerify ? 'mdi-eye' : 'mdi-eye-off'"  :type="showRegisterVerify ? 'text' : 'password'" name="input-10-1"  counter @click:append="showRegisterVerify = !showRegisterVerify" outlined  clearable></v-text-field>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col class="d-flex ml-auto" cols="12">
                                            <v-btn x-large block :disabled="!registerBtn" color="success" v-model="submitRegister" @click="registerRequest">Register</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </div>

        </v-dialog>
    </v-app>
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

      usernameLogin: '',
      passwordLogin: '',
      emailRegister: '',
      usernameRegister: '',
      passwordRegister: '',
      verifyRegister: '',
      data: null,
      
      dialog: true,
      loginBtn: false,
      registerBtn: false,
      tab: 0,
      tabs: [
        {name:"Login", icon:"mdi-account"},
        {name:"Register", icon:"mdi-account-outline"}
    ],
    showLoginPassword: false,
    showRegisterPassword: false,
    showRegisterVerify: false,

    rules: {
        required: value => !!value || "This field is required.",

    },
    alertDisplay: false,
    alertType: '',
    alertMessage: '',

    alertDisplayRegister: false,
    alertTypeRegister: '',
    alertMessageRegister: '',

  }),
  methods: {

    unlockLogin(){
      if(this.usernameLogin === '' || this.passwordLogin === ''){
        this.loginBtn = false;
      }else{
        this.loginBtn = true;
      }
    },

    unlockLoginRegister(){
      if(this.emailRegister === '' || this.usernameRegister === '' || this.passwordRegister === '' || this.verifyRegister === '' || this.passwordRegister != this.verifyRegister){
        this.registerBtn = false;
      }else{
        this.registerBtn = true;
      }
    },

    async loginRequest(){
        const loginResponse = await axios.post('./Controller/login.php', {
        usernameLogin: this.usernameLogin,
        passwordLogin: this.passwordLogin,
    })
        console.log(loginResponse.data)
        this.alertMessage = loginResponse.data.text;
        this.alertDisplay = true; 
    switch (loginResponse.data.type) {
        case "ERROR":
            this.alertType = "error";
            break;
        case "SUCCESS":
            this.alertDisplay = false;
            window.location.reload();
            break;    
        default:
            this.alertType = "warning";
            break;
    }
  },

    displayAlert(type,text){
        console.log("On rentre")
        this.alertDisplay = !this.alertDisplay
        this.alertType = type
        this.alertMessage = text

    },

    async registerRequest() {
        const registerResponse = await axios.post('./Controller/register.php', {
        emailRegister: this.emailRegister,
        usernameRegister: this.usernameRegister,
        passwordRegister: this.passwordRegister,
        verifyRegister: this.verifyRegister,
   })
        console.log(registerResponse.data)
        this.alertMessageRegister = registerResponse.data.text;
        this.alertDisplayRegister = true; 
    switch (registerResponse.data.type) {
        case "ERROR":
            this.alertTypeRegister = "error";
            break;
        case "SUCCESS":
            this.alertTypeRegister = "success";
            break;    
        default:
            this.alertTypeRegister = "warning";
            break;
    }
    },

  },

});
  </script>