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
                {{experience.school_name}}
              </div>
              <v-list-item-subtitle>{{experience.country.entity}} · From {{experience.start}} to {{experience.end}}</v-list-item-subtitle>
              <v-list-item-title class="headline mb-1">
                {{experience.education}}
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
          <span class="headline">Add School</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formSchool.school_name"
                  label="School Name*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formSchool.education"
                  label="Education*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="formSchool.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-textarea>
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
                      v-model="formSchool.start"
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
                    v-model="formSchool.start"
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
                      v-model="formSchool.end"
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
                    v-model="formSchool.end"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12"
              >
                                     
              <v-autocomplete
                v-model="formSchool.location_country"
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
                  v-model="formEditSchool.school_name"
                  label="School Name*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditSchool.education"
                  label="Education*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="formEditSchool.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-textarea>
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
                      v-model="formEditSchool.start"
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
                    v-model="formEditSchool.start"
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
                      v-model="formEditSchool.end"
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
                    v-model="formEditSchool.end"
                  ></v-date-picker>
                </v-menu>
              </v-col>
              <v-col
                cols="12"
              >
                                     
              <v-autocomplete
                v-model="formEditSchool.location_country"
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
        <v-card-text>{{tempSchool.education}}</v-card-text>
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
            @click="confirmDel(tempSchool.id)"
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
        tempSchool:[],
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
        formSchool:{
          school_name:null,
          education:null,
          location_country:null,
          start:null,
          end:null,
          actual:null,
          description:null,

        },
        formEditSchool:{
          school_name:null,
          education:null,
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
    tempSchool: {
      handler (val) {
        //console.log('watch', val);
        this.formEditSchool.education = this.tempSchool.education;
        this.formEditSchool.school_name = this.tempSchool.school_name;
        this.formEditSchool.start = this.tempSchool.start;
        this.formEditSchool.end = this.tempSchool.end;
        this.formEditSchool.description = this.tempSchool.description;
        this.formEditSchool.location_country = this.tempSchool.location_country;
        this.formEditSchool.id = this.tempSchool.key;
        
      },
      deep: true,
    },

    },
    methods:{
    confirmDel(experience){
      axios
        .get('chefe/school/delete/'+experience)
        .then(response => (this.getSchool(),this.deleteM=false));
    },
    edit(experience){
      axios
        .get('chefe/school/get/'+experience)
        .then(response => (this.tempSchool = response.data, this.dialogEdit=true));
    },
    deleteEx(experience){
      axios
        .get('chefe/school/get/'+experience)
        .then(response => (this.tempSchool = response.data, this.deleteM=true));
    },
    getSchool(){
      axios
          .get('chefe/school/getThis')
          .then(response => (this.experiences = response.data));
    },
    validate() {
      if (this.$refs.priceForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formSchool);
        this.dialog = false;
      }
    },
    validateEdit() {
      if (this.$refs.editForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendDataEit(this.formEditSchool);
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
      .post("chefe/school/new", { data: { schoolData: data} })
      .then(response => {
          this.getSchool();
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
      .post("chefe/school/update/"+this.formEditSchool.id, { data: { experienceData: data} })
      .then(response => {
          this.getSchool();
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
    this.getSchool();
    axios
        .get('getCurrencyArr')
        .then(response => (this.currencys = response.data));
      },
      
  }
</script>