<template>
<div max-width="600px" min-width="360px">
            <div>
                <v-tabs v-model="tab" show-arrows background-color="grey darken-3" icons-and-text dark grow>
                    <v-tabs-slider color="purple darken-4"></v-tabs-slider>
                    <v-tab v-for="(i,index) in tabs" :key="index">
                        <v-icon large>{{ i.icon }}</v-icon>
                        <div class="caption py-1">{{ i.name }}</div>
                    </v-tab>
                    <v-tab-item>
                      <loginView/>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card class="px-4">
                            <v-card-text>
                                <v-form ref="registerForm" v-model="valid" lazy-validation>
                                    <v-row>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field dense v-model="formReg.name"  label="First Name" maxlength="255" :counter="255" required :rules="[rules.required]"></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="6" md="6">
                                            <v-text-field dense v-model="formReg.lastName"  label="Last Name" maxlength="255" :counter="255" :rules="[rules.required]" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field dense v-model="formReg.email" :rules="emailRules" label="E-mail" :counter="255" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12" sm="4" md="4">
                                          <v-autocomplete
                                            v-model="formReg.prefix_phone_1"
                                            :items="countrys"
                                            label="Prefix"
                                            required
                                            item-text="phone"
                                            return-object
                                            :rules="[rules.required]"
                                            dense
                                          >
                                          </v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" sm="8" md="8">
                                            <v-text-field dense v-model="formReg.phone1" type="number"  :rules="[rulesPhone.required,rulesPhone.min]" label="Phone Number" maxlength="9" :counter="9" required></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                          <v-menu
                                            ref="menu"
                                            v-model="menu"
                                            :close-on-content-click="false"
                                            transition="scale-transition"
                                            offset-y
                                            min-width="auto"
                                            dense
                                          >
                                            <template v-slot:activator="{ on, attrs }">
                                              <v-text-field
                                                v-model="formReg.dataBrith"
                                                label="Birthday date"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                                :rules="[rules.required]"
                                                dense
                                              ></v-text-field>
                                            </template>
                                            <v-date-picker
                                              ref="picker"
                                              v-model="formReg.dataBrith"
                                              :max="new Date(new Date().setFullYear(new Date().getFullYear() - 18)).toISOString().substr(0, 10)"
                                              min="1950-01-01"
                                              @change="save"
                                              dense
                                            ></v-date-picker>
                                          </v-menu>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field dense v-model="formReg.password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters" counter @click:append="show1 = !show1"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-text-field dense block v-model="formReg.password_confirmation" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, passwordMatch]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirm Password" counter @click:append="show1 = !show1"></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                          <v-checkbox dense v-model="formReg.terms_conditions" :rules="[rules.required]">
                                            <template v-slot:label>
                                              <div>
                                                I have read and agree to the
                                                <v-tooltip bottom>
                                                  <template v-slot:activator="{ on }">
                                                    <a
                                                      target="_blank"
                                                      href="/terms"
                                                      @click.stop
                                                      v-on="on"
                                                    >
                                                      Terms of Service
                                                    </a>
                                                  </template>
                                                  Open Terms and condition
                                                </v-tooltip>
                                              </div>
                                            </template>
                                          </v-checkbox>
                                        </v-col>
                                        <v-spacer></v-spacer>
                                        <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                                            <v-btn elevation="1" block :disabled="!valid" color="brown lighten-5" @click="validate">Register</v-btn>
                                        </v-col>
                                    </v-row>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </div>
        </div>
</template>

<script>

import loginView from './Login.vue';

export default {
  components: {loginView},
  computed: {
    passwordMatch() {
      return () => this.password === this.password_confirmation || "Password must match";
    }
  },
  methods: {
      save (date) {
        //this.$refs.menu.save(formReg.dataBrith)
      },
    validate() {
      if (this.$refs.registerForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formReg);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    sendData(data) {
      axios
      .post("register", { data: { userData: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

          } else {

              this.openNotification('success', 'Save', 'You have been store all data successfully');
              this.$router.push({ name: 'register/result' });
          }
      })
      .catch((error) => {
        this.success = false;
        var errors =null;
        var status=error.response.status;
        //console.log(status);
            if (status == 422){
            errors=error.response.data.errors;
            //console.log(errors);
            errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
          }else{
            this.openNotification('error','Error on Save',error);
          }
      });
  },
  openNotification: function (type, m, d) {
      this.$notification.config({
          placement: 'topRight',
          top: 35,
          duration: 8,
      });
      this.$notification[type]({
        message: m,
        description: d,
      });
  },

  },
  data: () => ({
    formReg:{
      name:null,
      lastName:null,
      prefix_phone_1:"",
      phone1:"",
      dataBrith: null,
      email: "",
      password: "",
      password_confirmation:null,
    },
    menu: false,
    userType:[
      {name:"Chef",type:"3"},
      {name:"Client",type:"2"},
    ],
    countrys:[],
    terms_conditions: false,
    dialog: true,
    tab: 1,
    tabs: [
        {name:"Login", icon:"mdi-account"},
        {name:"Register", icon:"mdi-account-outline"}
    ],
    valid: true,
    verify: "",
    loginPassword: "",
    loginEmail: "",
    loginEmailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],
    emailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],

    show1: false,
    rules: {
      required: value => !!value || "Required.",
      min: v => (v && v.length >= 8) || "Min 8 characters"
    },
    rulesPhone: {
      required: value => !!value || "Required.",
      min: v => (v && v.length >= 9) || "Min 9 characters"
    }
  }),

  mounted() {
  axios
      .get('getCountryStates')
      .then(response => (this.countrys = response.data));
  },
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
  },


};

</script>

