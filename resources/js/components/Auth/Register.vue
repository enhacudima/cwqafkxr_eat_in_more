<template>

  <a-form  layout="horizontal" :form="form" @submit="handleSubmit" style="text-align: center;" >

    <a-form-item  :validate-status="nameError() ? 'error' : ''" :help="nameError() || ''">
      <a-input
        v-decorator="[
          'name',
          { rules: [{ required: true, message: 'Please input your name!' }] },
        ]"
        placeholder="Name"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    <a-form-item  :validate-status="lastNameError() ? 'error' : ''" :help="lastNameError() || ''">
      <a-input
        v-decorator="[
          'lastName',
          { rules: [{ required: true, message: 'Please input your Last name!' }] },
        ]"
        placeholder="Last Name"
        allow-clear
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    <a-form-item  :validate-status="dataBrithError() ? 'error' : ''" :help="dataBrithError() || ''">
      <a-input
        v-decorator="[
          'dataBrith',
          { rules: [{ required: true, message: 'Please input your Date of Brith!' }] },
        ]"
        type="date"
        placeholder="Date of Brith"
      >
      </a-input>
    </a-form-item>

    <a-form-item  :validate-status="typeError() ? 'error' : ''" :help="typeError() || ''">
      <a-select
        v-decorator="[
          'type',
          { rules: [{ required: true, message: 'Please input your user type!' }] },
        ]"
        placeholder="Select User type"
      >
        <a-select-option value="2">
            Client
        </a-select-option>
        <a-select-option value="3">
            Chefe
        </a-select-option>
      </a-select>
    </a-form-item>

    <a-form-item :validate-status="phone1Error() ? 'error' : ''" :help="phone1Error() || ''">
        <a-input v-decorator="[
      'phone1',
      {
        rules: [{ required: true, message: 'Please input your phone number 1!' }],
      },
    ]"
        placeholder="84*******"
        type="number"
        allow-clear
        >
            <a-select slot="addonBefore"
                      placeholder="(ZA) +278"
                      v-decorator="['prefix_phone_1', 
                      {
                        rules: [{ required: true, message: 'Please input your phone number 1!' }],
                      }
                      ]"
                      style="width: 125px">
                <a-select-option v-for="country in countrys"  v-bind:value="country.id" :key="country.id" >
                  ({{ country.internet.toUpperCase()}}) +{{ country.phone }}
                </a-select-option>

            </a-select>
        </a-input>
    </a-form-item>

    <a-form-item  :validate-status="emailError() ? 'error' : ''" :help="emailError() || ''">
      <a-input
        v-decorator="[
          'email',
          { rules: [{ required: true, message: 'Please input your email!' }] },
        ]"
        placeholder="Email"
        allow-clear
      >
        <a-icon slot="prefix" type="global" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    <a-form-item :validate-status="passwordError() ? 'error' : ''" :help="passwordError() || ''" has-feedback>
      <a-input
        v-decorator="[
          'password',
          { rules: [{ 
            required: true,
            message: 'Please input your Password!' }, 
            {
             validator: validateToNextPassword, 
            },

            ] },
        ]"
        type="password"
        placeholder="Password"
        allow-clear
      >
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item :validate-status="password_confirmationError() ? 'error' : ''" :help="password_confirmationError() || ''" has-feedback>
      <a-input
        v-decorator="[
          'password_confirmation',
          { rules: [{ 
            required: true,
            message: 'Please Confirm your Password!' }, 
            {
             validator: compareToFirstPassword, 
            },

            ] },
        ]"
        type="password"
        @blur="handleConfirmBlur"
        placeholder="confirm Password"
        allow-clear
      >
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    <a-form-item :validate-status="terms_conditionsError() ? 'error' : ''" :help="terms_conditionsError() || ''">
      <a-checkbox 
        v-decorator="[
          'terms_conditions',
          { valuePropName: 'checked',
            rules: [{ required: true, message: 'Please agree with terms and conditions!' }]
           },
        ]"
      >
        I agree with <a href="#">terms and conditions.</a>

      </a-checkbox>
    </a-form-item>

    <a-form-item>
      <a-button icon="check-circle"  type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())" :style="{ marginRight:  '2%'}">
          Done
      </a-button >
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
      hasErrors,
      form: this.$form.createForm(this, { name: 'horizontal_login' }),
      countrys:'',
      provinceStates:'',
      selectedProvinceStates:'',
    };
  },
  mounted() {
    this.$nextTick(() => {
      // To disabled submit button at the beginning.
      this.form.validateFields();
    });
  },
  methods: {
    handleConfirmBlur(e) {
      const value = e.target.value;
      this.confirmDirty = this.confirmDirty || !!value;
    },
    compareToFirstPassword(rule, value, callback) {
      const form = this.form;
      if (value && value !== form.getFieldValue('password')) {
        callback('Two passwords that you enter is inconsistent!');
      } else {
        callback();
      }
    },
    validateToNextPassword(rule, value, callback) {
      const form = this.form;
      if (value && this.confirmDirty) {
        form.validateFields(['confirm'], { force: true });
      }
      callback();
    },
    filterStates(event){
     this.form.setFields({
                          "province": {
                            "values": [
                              {
                                "province": "",
                              }
                            ]
                          },
                        });
      const search = event.toLowerCase().trim();
     if (!search) return null;
     this.selectedProvinceStates =  this.provinceStates.filter(function(country) {
      return country.country_name.toLowerCase() == search;
     });
    },
    // Only show error after a field is touched.
    lastNameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('lastName') && getFieldError('lastName');
    },
    nameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('name') && getFieldError('name');
    },
    emailError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('email') && getFieldError('email');
    },
    typeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('type') && getFieldError('type');
    },
    countryError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('country') && getFieldError('country');
    },
    provinceError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('province') && getFieldError('province');
    },
   /* postalCodeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('postalCode') && getFieldError('postalCode');
    },*/
    dataBrithError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('dataBrith') && getFieldError('dataBrith');
    },
    phone1Error() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('phone1') && getFieldError('phone1');
    },
    /*userNameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('userName') && getFieldError('userName');
    },*/
    // Only show error after a field is touched.
    password_confirmationError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('password_confirmation') && getFieldError('password_confirmation');
    },
    terms_conditionsError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('terms_conditions') && getFieldError('terms_conditions');
    },
    passwordError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('password') && getFieldError('password');
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
  mounted() {
  axios
      .get('getCountryStates')
      .then(response => (this.countrys = response.data));
  },
  computed: {
    filteredClients() {
      this.selectedCountry="canada";
      const search = this.selectedCountry.toLowerCase().trim();
      //console.log(selectedCountry);
     //if (!search) return this.clients;
     return this.provinceStates.filter(c => c.country_name.toLowerCase().indexOf("canada") > -1);
     console.log(provinceStates);
  }},
};
</script>

