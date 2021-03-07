<template>

  <a-form  layout="horizontal" :form="form" @submit="handleSubmit" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" >

    <v-col cols="12">
    <a-form-item label="Linkedin" :validate-status="linkedinError() ? 'error' : ''" :help="linkedinError() || ''">
      <a-input
        v-decorator="[
          'linkedin',
          {initialValue:contact.linkedin, rules: [{ required: true, message: 'Please input your Linkedin!' }] },
        ]"
        placeholder="Linkedin"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    </v-col>
    <v-divider class="mx-6"></v-divider>

    <v-col cols="12">
      <a-form-item label="1 Reference Name" :validate-status="re1nameError() ? 'error' : ''" :help="re1nameError() || ''">
      <a-input
        v-decorator="[
          're_1_name',
          {initialValue:contact.re_1_name, rules: [{ required: true, message: 'Please input your Reference Name!' }] },
        ]"
        placeholder="Reference Name"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
      <a-form-item label="1 Reference Phone" :validate-status="re1phoneError() ? 'error' : ''" :help="re1phoneError() || ''">
      <a-input
        v-decorator="[
          're_1_phone',
          {initialValue:contact.re_1_phone, rules: [{ required: true, message: 'Please input your Reference Phone!' }] },
        ]"
        placeholder="Reference Phone"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
      <a-form-item label="1 Reference Email" :validate-status="re1emailError() ? 'error' : ''" :help="re1emailError() || ''">
      <a-input
        v-decorator="[
          're_1_email',
          {initialValue:contact.re_1_email, rules: [{ required: true, message: 'Please input your Reference Email!' }] },
        ]"
        placeholder="Reference Email"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    </v-col>
    <v-divider class="mx-6"></v-divider>
    
    <v-col cols="12">
      <a-form-item label="2 Reference Name" :validate-status="re2nameError() ? 'error' : ''" :help="re2nameError() || ''">
      <a-input
        v-decorator="[
          're_2_name',
          {initialValue:contact.re_2_name, rules: [{ required: true, message: 'Please input your Reference Name!' }] },
        ]"
        placeholder="Reference Name"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
      <a-form-item label="2 Reference Phone" :validate-status="re2phoneError() ? 'error' : ''" :help="re2phoneError() || ''">
      <a-input
        v-decorator="[
          're_2_phone',
          {initialValue:contact.re_2_phone, rules: [{ required: true, message: 'Please input your Reference Phone!' }] },
        ]"
        placeholder="Reference Phone"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
      <a-form-item label="2 Reference Email" :validate-status="re2emailError() ? 'error' : ''" :help="re2emailError() || ''">
      <a-input
        v-decorator="[
          're_2_email',
          {initialValue:contact.re_2_email, rules: [{ required: true, message: 'Please input your Reference Email!' }] },
        ]"
        placeholder="Reference Email"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    </v-col>


    <a-form-item >
      <a-col :xs="{ span: 24, offset: 0}" :lg="{ span: 20, offset: 10}"> 
          <a-button icon="check-circle"  type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())" >
              Save
          </a-button >
      </a-col>
    </a-form-item>

  </a-form>
</template>

<script>

function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
export default {
  data() {
    return {
      loading: false,
      hasErrors,
      form: this.$form.createForm(this, { name: 'horizontal_login' }),
      experiences:'',
      userInfo: localStorage.getItem('user'),
      userID: '',
      contact: '',

    };
  },
  mounted() {
    this.$nextTick(() => {
      // To disabled submit button at the beginning.
      this.form.validateFields();
    });
  },
  methods: {
    re1phoneError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_1_phone') && getFieldError('re_1_phone');
    },
        
    re1emailError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_1_email') && getFieldError('re_1_email');
    },   

    re1nameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_1_name') && getFieldError('re_1_name');
    },
    
    re2phoneError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_2_phone') && getFieldError('re_2_phone');
    },
        
    re2emailError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_2_email') && getFieldError('re_2_email');
    },   

    re2nameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('re_2_name') && getFieldError('re_2_name');
    },

    linkedinError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('linkedin') && getFieldError('linkedin');
    },

    handleSubmit(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          console.log('Received values of form: ', values);
          this.sendData(values);
        }
      });
    },
  sendData(data) {
      axios
      .post("create/references", { data: { referenceDate: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been store all data successfully');
              //this.$router.push({ name: 'register/result' });
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
  mounted() {
    const userData = JSON.parse(this.userInfo);
    this.userID = userData.logged_in_user.id;
  axios
      .get('getContactData/'+this.userID)
      .then(response => (this.contact = response.data));
  },
};
</script>

