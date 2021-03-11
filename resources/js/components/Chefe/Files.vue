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
      <v-col cols="3" justify="center" v-for="(file, index) in files" :key="index" class="pb-6 pl-6 pr-6">
        <v-card
          cols="12"
          outlined
        >
          <v-list-item three-line>
            <v-list-item-content>
              <div class="overline mb-4">
                {{file.name}}
              </div>
              <v-list-item-title class="headline mb-1">
                {{file.file_type.name}}
              </v-list-item-title>
            </v-list-item-content>

          </v-list-item>

          <v-card-actions>
            <v-btn
              outlined
              rounded
              text
              color="error"
              @click="deleteFile(file.key)"
            >
              Delete
            </v-btn>
            <v-btn
              outlined
              rounded
              text
              :href="'storage/'+file.files.path+file.files.name" target="_blank"
            >
              Open
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
          <span class="headline">Add File</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formFile.name"
                  label="Name*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
            <v-col cols="12">                     
              <v-autocomplete
                v-model="formFile.type"
                :items="fileType"
                label="Type*"
                required
                :rules="[rules.required]"
                item-text="type"
                item-value="id"
                return-object
              >
              </v-autocomplete>
              </v-col>
              <v-col cols="12">
                <a-upload
                  name="file"
                  :multiple="false"
                  action="/cwqafkxr_eat_in_more/public/api/fileOtherFormat"
                  :headers="headers"
                  @change="handleChange"
                >
                  <a-button> <a-icon type="upload" /> Click to Upload </a-button>
                </a-upload>

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
      v-model="deleteM"
      persistent
      max-width="290"
    >
      <v-card>
        <v-card-title class="headline">
          Delete File?
        </v-card-title>
        <v-card-text>{{tempFile.name}}</v-card-text>
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
            @click="confirmDel(tempFile.key)"
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
        headers: {
          authorization: 'authorization-text',
        },
        deleteM:false,
        fileInfo:null,
        tempFile:[],
        files:[],
        valid: true,
        rules: {
          required: value => !!value || "Required.",
        },
        fileRules: [
            value => !value || value.size < 5000000 || 'Avatar size should be less than 5 MB!',
            value => !!value || "Required.",
        ],
        formFile:{
          name:null,
          type:null,
          file:null,

        },
        fileType:[
            {type:"CV",id:"1"},
            {type:"Certificate",id:"2"},
            {type:"letter",id:"3"},
            {type:"Other Doc",id:"4"},
            {type:"Other Picture",id:"5"}
        ],
        dialog:false,
      }
    },
    watch: {

    },
    methods:{
    handleChange(info) {
        if (info.file.status !== 'uploading') {
          console.log(info.file, info.fileList);
        }
        if (info.file.status === 'done') {
          this.$message.success(`${info.file.name} file uploaded successfully`);
          this.fileInfo=info.file.response;
        } else if (info.file.status === 'error') {
          this.$message.error(`${info.file.name} file upload failed.`);
        }
      },
    confirmDel(file){
      axios
        .get('chefe/file/delete/'+file)
        .then(response => (this.getFiles(),this.deleteM=false));
    },
    deleteFile(file){
      axios
        .get('chefe/file/get/'+file)
        .then(response => (this.tempFile = response.data, this.deleteM=true));
    },
    getFiles(){
      axios
          .get('chefe/files/getThis')
          .then(response => (this.files = response.data));
    },
    validate() {
      if (this.$refs.priceForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formFile);
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
      .post("chefe/files/new", { data: { fileData: data,fileInfo:this.fileInfo} })
      .then(response => {
          this.getFiles();
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
          this.getFiles();
      },
      
  }
</script>