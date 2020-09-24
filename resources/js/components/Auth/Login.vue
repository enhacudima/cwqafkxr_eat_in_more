<template>
  <a-form
    id="components-form-demo-normal-login"
    :form="form"
    class="login-form"
    @submit="handleSubmit"
  >
    <a-form-item >
      <a-input 
        v-decorator="[
          'userName',
          { rules: [{ required: true, message: 'Please input your username!' }] },
        ]"
        placeholder="Username"
      >
        <a-icon slot="prefix" type="user" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item >
      <a-input
        v-decorator="[
          'password',
          { rules: [{ required: true, message: 'Please input your Password!' }] },
        ]"
        type="password"
        placeholder="Password"
      >
        <a-icon slot="prefix" type="lock" style="color: rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-checkbox
        v-decorator="[
          'remember',
          {
            valuePropName: 'checked',
            initialValue: true,
          },
        ]"
      >
        Remember me
      </a-checkbox>
      <a class="login-form-forgot" href="">
        Forgot password
      </a>
      <a-button type="primary" html-type="submit" class="login-form-button">
        Log in
      </a-button>
      Or
      <router-link to="/register" class="nav-item nav-link">
        register now!
      </router-link>  
    </a-form-item>
  </a-form>
</template>

<script>
export default {
  data() {
    return {
      testError:'',
      country:'',
      user_id:'',
      allerros:'',
      sucess:'',
    };
  },
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: 'normal_login' });
  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          this.login(values.userName,values.password);
          //console.log('Received values of form: ', values);
        }
      });
    },

    login (email,password) {
      this.$store
        .dispatch('login', {
          email: email,
          password: password
        })
        .then(() => {
          this.$router.push({ name: 'home' })
        })
        .catch(err => {
        var errors =null;
        var status=err.response.status;
        //console.log(status);
            if (status == 403){
             var inval=err.response.data.error;
             this.form.setFields({
                                  "userName": {
                                    "errors": [
                                      {
                                        "message": inval,
                                        "field": "userName"
                                      }
                                    ]
                                  }
                                });
                this.user_id=err.response.data.id;

                this.openVerifyNotification();
            }
            if (status == 422){
             const {
                    errors
                } = err.response.data;

                if (errors) {
                 this.form.setFields({
                                      "userName": {
                                        "errors": [
                                          {
                                            "message": errors.email,
                                            "field": "userName"
                                          }
                                        ]
                                      },
                                      "password": {
                                        "errors": [
                                          {
                                            "message": errors.password,
                                            "field": "password"
                                          }
                                        ]
                                      }
                                    });
              }
             if (err.response.data.error) {
             var inval=err.response.data.error;
             this.form.setFields({
                                  "userName": {
                                    "errors": [
                                      {
                                        "message": inval,
                                        "field": "userName"
                                      }
                                    ]
                                  }
                                });
              }
          }if (status != 422 && status != 403){
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
        .post('email/resend', { data: { id: this.user_id} })
        .then(response => {
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                response.data.errors.forEach(error => { this.openNotification('error', 'Error on resend', error);});
                
            } else {
                
                this.openNotification('success', 'Resend', 'You have been resend link successfully');
            }
        })
      .catch((error) => {
        this.success = false;
        var errors =null;
        var status=error.response.status;
            if (status == 422){
            errors=error.response.data.errors;
            errors.forEach(error => { this.openNotification('error', 'Error on resend', error);});
          }else{
            this.openNotification('error','Error on resend',error.response.data['error']);
          }
      });

        this.$notification.close(key)
    },
    openVerifyNotification() {
      const key = `open${Date.now()}`;
      this.$notification.open({
        message: 'Email verification',
        placement:'bottomRight',
        description:
          'You can click resend to verify your email.',
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
            'Resend',
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
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>