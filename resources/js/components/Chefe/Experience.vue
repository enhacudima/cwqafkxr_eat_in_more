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
    <v-row dense >
      <v-col cols="12" justify="center" v-for="(experience, index) in experiences" :key="index" class="pb-6 pl-6 pr-6">
        <v-card
          cols="12"
          outlined
        >
          <v-list-item three-line>
            <v-list-item-content>
              <div class="overline mb-4">
                {{experience.company_name}}
              </div>
              <v-list-item-subtitle>{{experience.country.entity}} · From {{experience.start}} to {{experience.end}}</v-list-item-subtitle>
              <v-list-item-title class="headline mb-1">
                {{experience.position}}
              </v-list-item-title>
              <v-list-item-subtitle>{{experience.description}}</v-list-item-subtitle>
            </v-list-item-content>

          </v-list-item>

          <v-card-actions>
            <v-btn
              outlined
              rounded
              text
              color="error"
              @click="deleteEx(experience.id)"
            >
              Delete
            </v-btn>
            <v-btn
              outlined
              rounded
              text
              @click="edit(experience.id)"
            >
              Edit
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
      
    </v-row>

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

    <v-dialog
      v-model="dialogEdit"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="editForm" v-model="validEdit" lazy-validation>
        <v-card-title>
          <span class="headline">Edit Experience</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditExperience.position"
                  label="Position*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="formEditExperience.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditExperience.company_name"
                  label="Company*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="6">
                
                <v-menu
                  ref="menu_3"
                  v-model="menu_3"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="formEditExperience.start"
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
                    v-model="formEditExperience.start"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col cols="6">
                <v-menu
                  ref="menu_4"
                  v-model="menu_4"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="formEditExperience.end"
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
                    v-model="formEditExperience.end"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12"
              >
                                     
              <v-autocomplete
                v-model="formEditExperience.location_country"
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
            @click="dialogEdit = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="validateEdit"
            :disabled="!validEdit"
          >
            Save
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    
    <v-dialog
      v-model="deleteM"
      persistent
      max-width="290"
    >
      <v-card>
        <v-card-title class="headline">
          Delete experience?
        </v-card-title>
        <v-card-text>{{tempExperience.position}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            text
            @click="deleteM = false"
          >
            No
          </v-btn>
          <v-btn
            color="green darken-1"
            text
            @click="confirmDel(tempExperience.id)"
          >
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    
  </div>
</template>
<script>
  export default {
    props: {
        
    },
    data () {
      return {
        deleteM:false,
        tempExperience:[],
        dialogEdit:false,
        experiences:[],
        menu_1: false,
        menu_2: false,
        menu_3: false,
        menu_4: false,
        valid: true,
        validEdit: true,
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
        formEditExperience:{
          position:null,
          company_name:null,
          location_country:null,
          start:null,
          end:null,
          actual:null,
          description:null,
          id:null,

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
    menu_3 (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    menu_4 (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    tempExperience: {
      handler (val) {
        //console.log('watch', val);
        this.formEditExperience.position = this.tempExperience.position;
        this.formEditExperience.company_name = this.tempExperience.company_name;
        this.formEditExperience.start = this.tempExperience.start;
        this.formEditExperience.end = this.tempExperience.end;
        this.formEditExperience.description = this.tempExperience.description;
        this.formEditExperience.location_country = this.tempExperience.location_country;
        this.formEditExperience.id = this.tempExperience.key;
        
      },
      deep: true,
    },

    },
    methods:{
    confirmDel(experience){
      axios
        .get('chefe/experience/delete/'+experience)
        .then(response => (this.getExperience(),this.deleteM=false));
    },
    edit(experience){
      axios
        .get('chefe/experience/get/'+experience)
        .then(response => (this.tempExperience = response.data, this.dialogEdit=true));
    },
    deleteEx(experience){
      axios
        .get('chefe/experience/get/'+experience)
        .then(response => (this.tempExperience = response.data, this.deleteM=true));
    },
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
    validateEdit() {
      if (this.$refs.editForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendDataEit(this.formEditExperience);
        this.dialogEdit = false;
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
    
    sendDataEit(data) {
      axios
      .post("chefe/experience/update/"+this.formEditExperience.id, { data: { experienceData: data} })
      .then(response => {
          this.getExperience();
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been update all data successfully');
              
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
    this.getExperience();
    axios
        .get('getCurrencyArr')
        .then(response => (this.currencys = response.data));
      },
      
  }
</script>