<template>
  <a-form layout="horizontal" :form="form" @submit="handleSubmit" style="text-align: center;">

    <a-form-item  :validate-status="nameError() ? 'error' : ''" :help="nameError() || ''">
      <a-input
        v-decorator="[
          'name',
          { rules: [{ required: true, message: 'Please input your name!' }] },
        ]"
        placeholder="Name"
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

    <a-form-item  :validate-status="countryError() ? 'error' : ''" :help="countryError() || ''">
      <a-select
        v-decorator="[
          'country',
          { rules: [{ required: true, message: 'Please input your Country!' }] },
        ]"
        placeholder="Select Country"
        @change="filterStates($event)"
      >
        <a-select-option v-for="country in countrys"  v-bind:value="country" :key="country" >
          {{ country }}
        </a-select-option>
      </a-select>
    </a-form-item>

    <a-form-item  :validate-status="provinceError() ? 'error' : ''" :help="provinceError() || ''">
      <a-select
        v-decorator="[
          'province',
          { rules: [{ required: true, message: 'Please input your province!' }] },
        ]"
        placeholder="Select State/Province"
      >
        <a-select-option v-for="state in selectedProvinceStates" v-bind:value="state.id"  :key="state.id">
          {{state.state_name}}
        </a-select-option>
      </a-select>
    </a-form-item>

    <a-form-item  :validate-status="postalCodeError() ? 'error' : ''" :help="postalCodeError() || ''">
      <a-input
        v-decorator="[
          'postalCode',
          { rules: [{ required: true, message: 'Please input your Date of Brith!' }] },
        ]"
        type="number"
        placeholder="Postal Code"
      >
      </a-input>
    </a-form-item>

    <a-form-item :validate-status="phone1Error() ? 'error' : ''" :help="phone1Error() || ''">
        <a-input v-decorator="[
      'phone1',
      {
        rules: [{ required: true, message: 'Please input your phone number 1!' }],
      },
    ]"
        placeholder="84******"
        type="number"
        >
            <a-select slot="addonBefore"
                      v-decorator="['prefix_phone_1', { initialValue: 'Mobile' }]"
                      style="width: 125px">
                <a-select-option value="Mobile">
                    Mobile
                </a-select-option>
                <a-select-option value="Home">
                    Home
                </a-select-option>
                <a-select-option value="Work">
                    Work
                </a-select-option>
                <a-select-option value="Work Fax">
                    Work Fax
                </a-select-option>
                <a-select-option value="Work Mobile">
                    Work Mobile
                </a-select-option>
                <a-select-option value="Work Pager">
                    Work Pager
                </a-select-option>
                <a-select-option value="Assistent">
                    Assistent
                </a-select-option>
                <a-select-option value="Home Fax">
                    Home Fax
                </a-select-option>
                <a-select-option value="Other">
                    Other
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
      >
        <a-icon slot="prefix" type="global" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>

    <a-form-item  :validate-status="userNameError() ? 'error' : ''" :help="userNameError() || ''">
      <a-input
        v-decorator="[
          'userName',
          { rules: [{ required: true, message: 'Please input your username!' }] },
        ]"
        placeholder="Username"
      >
        <a-icon slot="prefix" type="user" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item :validate-status="passwordError() ? 'error' : ''" :help="passwordError() || ''">
      <a-input
        v-decorator="[
          'password',
          { rules: [{ required: true, message: 'Please input your Password!' }] },
        ]"
        type="password"
        placeholder="Password"
        allow-clear
      >
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item :validate-status="password_confirmationError() ? 'error' : ''" :help="password_confirmationError() || ''">
      <a-input
        v-decorator="[
          'password_confirmation',
          { rules: [{ required: true, message: 'Please Confirm your Password!' }] },
        ]"
        type="password"
        placeholder="confirm Password"
        allow-clear
      >
        <a-icon slot="prefix" type="lock" style="color:rgba(0,0,0,.25)" />
      </a-input>
    </a-form-item>
    <a-form-item>
      <a-button icon="check-circle"  type="default" html-type="submit" :disabled="hasErrors(form.getFieldsError())" :style="{ marginRight:  '2%'}">
         Save
      </a-button >
      <router-link to="/login" class="nav-item nav-link">
      <a-button icon="close-circle" type="default" >
          Cancel
        </a-button>
      </router-link>
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
    countryError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('country') && getFieldError('country');
    },
    provinceError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('province') && getFieldError('province');
    },
    postalCodeError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('postalCode') && getFieldError('postalCode');
    },
    dataBrithError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('dataBrith') && getFieldError('dataBrith');
    },
    phone1Error() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('phone1') && getFieldError('phone1');
    },
    userNameError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('userName') && getFieldError('userName');
    },
    // Only show error after a field is touched.
    password_confirmationError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('password_confirmation') && getFieldError('password_confirmation');
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
      .post("register", { data: { userDate: data} })
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
      .get('getCountry')
      .then(response => (this.countrys = response.data.country,this.provinceStates=response.data.all));
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

