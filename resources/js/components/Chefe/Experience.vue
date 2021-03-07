<template>
  <div justify="center">
    <v-row class="pb-6 pr-6" cols="12" justify="end">
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
      @click="dialog = true"
    >
      <v-icon dark>
        mdi-plus
      </v-icon>
    </v-btn>

    </v-row>
    <v-row colos="12" justify="center">
      <v-card>
          5555
      </v-card>
    </v-row>

  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="priceForm" v-model="valid" lazy-validation>
        <v-card-title>
          <span class="headline">Add Experience</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formExperience.position"
                  label="Position*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="formExperience.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formExperience.company_name"
                  label="Company*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                
                <v-menu
                  ref="menu_1"
                  v-model="menu_1"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="formExperience.start"
                      label="Start date*"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :rules="[rules.required]"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    ref="picker"
                    v-model="formExperience.start"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6">
                <v-menu
                  ref="menu_2"
                  v-model="menu_2"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="formExperience.end"
                      label="End date*"
                      prepend-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :rules="[rules.required]"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    ref="picker"
                    v-model="formExperience.end"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12"
              >
                                     
              <v-autocomplete
                v-model="formExperience.location_country"
                :items="currencys"
                label="Country*"
                required
                :rules="[rules.required]"
                item-text="entity"
                item-value="id"
                return-object
              >
              </v-autocomplete>

              </v-col>
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="validate"
            :disabled="!valid"
          >
            Save
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
    
  </div>
</template>
<script>
  export default {
    props: {
        
    },
    data () {
      return {
        experiences:[],
        menu_1: false,
        menu_2: false,
        valid: true,
        rules: {
          required: value => !!value || "Required.",
        },
        formExperience:{
          position:null,
          company_name:null,
          location_country:null,
          start:null,
          end:null,
          actual:null,
          description:null,

        },
        currencys:[],
        dialog:false,
      }
    },
    watch: {
    menu_1 (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    menu_2 (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },

    },
    methods:{
    getExperience(){
      axios
          .get('chefe/experience/getThis')
          .then(response => (this.experiences = response.data));
    },
    validate() {
      if (this.$refs.priceForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formExperience);
        this.dialog = false;
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
      .post("chefe/experience/new", { data: { experienceData: data} })
      .then(response => {
          this.getExperience();
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been store all data successfully');
              
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
        .get('getCurrencyArr')
        .then(response => (this.currencys = response.data));
      }
  }
</script>