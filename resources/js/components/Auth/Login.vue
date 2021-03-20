<template>
  <v-card class="px-4">
      <v-card-text>
          <v-form ref="loginForm" v-model="valid" lazy-validation>
              <v-row>
                  <v-col cols="12">
                      <v-text-field v-model="loginEmail" :rules="loginEmailRules" label="E-mail" required></v-text-field>
                  </v-col>
                  <v-col cols="12">
                      <v-text-field autocomplete="off" v-model="loginPassword" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" hint="At least 8 characters"  :error-messages="loginError" counter @click:append="show1 = !show1"></v-text-field>
                  </v-col>
                  <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                      <v-btn elevation="1" large block  color="success" @click="validate"> Login </v-btn>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-row>
                    <v-col class="d-flex" cols="12" sm="12" xsm="12">
                        <v-tooltip bottom >
                        <template v-slot:activator="{ on }">
                            <a
                            target="_blank"
                            href="forgetPassword"
                            @click.stop
                            v-on="on"
                            >
                            Forgot password
                            </a>
                        </template>
                        Use this link to reset you password
                        </v-tooltip>
                        <div class="pl-3">
                        Or

                        </div>
                        <div class="pl-3">
                        <router-link to="/register" class="">
                            Register now!
                        </router-link>
                        </div>
                    </v-col>
                  </v-row>
              </v-row>
          </v-form>
      </v-card-text>

    <v-dialog
      v-model="dialogW"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Please stand by
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      dialogW:false,
      loginError:null,
      dialog: true,
      tab: 0,
      tabs: [
          {name:"Login", icon:"mdi-account"},
      ],
      valid: true,
      loginPassword: "",
      loginEmail: "",
      loginEmailRules: [
        v => !!v || "Required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      show1: false,
      rules: {
        required: value => !!value || "Required.",
        min: v => (v && v.length >= 8) || "Min 8 characters"
      },
      testError:'',
      country:'',
      user_id:'',
      verMessage:'',
      verUrl:'',
      allerros:'',
      sucess:'',
      verDescription: '',
      verButtonMessage: '',
    };
  },
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: 'normal_login' });
  },
  methods: {
    validate() {
      if (this.$refs.loginForm.validate()) {
        // submit form to server/API here...
        this.dialogW=true;
        this.login(this.loginEmail,this.loginPassword);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },

    login (email,password) {
      this.$store
        .dispatch('login', {
          email: email,
          password: password
        })
        .then(() => {
          this.dialogW=false;
          this.$router.push({ name: 'home' })
        })
        .catch(err => {
        this.dialogW=false;
        var errors =null;
        var status=err.response.status;
        //console.log(status);
            if (status == 403){
                this.user_id=err.response.data.id;
                this.verDescription=err.response.data.description;
                this.verMessage=err.response.data.message;
                this.verUrl=err.response.data.url;
                this.verButtonMessage=err.response.data.button;

                this.openVerifyNotification();
            }
            if (status == 422){
             const errors = err.response.data;

              //console.log(errors.error);
              this.loginError=errors.error;
              //this.openNotification('error', 'Error on Save', errors.error);

          }if (status != 422 && status != 403){
            this.dialogW=false;
            this.openNotification('error','Error during login','Please contact admin web-site');
          }
        })
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
    closeNotification(key){
        axios
        .post(this.verUrl, { data: { id: this.user_id} })
        .then(response => {
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                response.data.errors.forEach(error => { this.openNotification('error', 'Action Button Error', error);});

            } else {

                this.openNotification('success', this.verMessage, 'Action Button successfully');
            }
        })
      .catch((error) => {
        this.success = false;
        var errors =null;
        var status=error.response.status;
            if (status == 422){
            errors=error.response.data.errors;
            errors.forEach(error => { this.openNotification('error', 'Action Button Error', error);});
          }else{
            this.openNotification('error','Action Button Error',error.response.data['error']);
          }
      });

        this.$notification.close(key)
    },
    openVerifyNotification() {
      const key = `open${Date.now()}`;
      this.$notification.open({
        message: this.verMessage,
        placement:'bottomRight',
        description:
           this.verDescription,
        btn: h => {
          return h(
            'a-button',
            {
              props: {
                type: 'primary',
                size: 'small',
              },
              on: {
                click: () => this.closeNotification(key),
              },
            },
            this.verButtonMessage,
          );
        },
        key,
        onClose: close,
        duration: 0,

      });
    },

  },
};
</script>
<style>
#components-form-demo-normal-login .login-form {
  max-width: 300px;
}
#components-form-demo-normal-login .login-form-forgot {
  float: right;
}
#components-form-demo-normal-login .login-form-Remember {
  float: left ;
}
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>
