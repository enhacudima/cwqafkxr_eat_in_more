<template>

  <a-form  :form="form" @submit="handleSubmit" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" >
  <a-row>  
    <a-form-item label="Picture">
      <div class="dropbox">
    <a-upload
      name="picture"
      list-type="picture-card"
      class="avatar-uploader"
      :show-upload-list="false"
      action="/laravel-passport-vue-sap/public/api/filePicture"
      :before-upload="beforeUpload"
      @change="handleChange"
    >
      <img v-if="imageUrl" :src="imageUrl" alt="picture" class="picture_avatar" />
      <div v-else>
        <a-icon :type="loading ? 'loading' : 'plus'" />
        <div class="ant-upload-text">
          Upload
        </div>
      </div>
    </a-upload>

      </div>
    </a-form-item>

    <a-form-item label="Name" :validate-status="titleError() ? 'error' : ''" :help="titleError() || ''">
      <a-input
        v-decorator="[
          'title',
          {initialValue:chefeCV.title, rules: [{ required: true, message: 'Please input your title!' }] },
        ]"
        placeholder="Title"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Alias" :validate-status="titleError() ? 'error' : ''" :help="titleError() || ''">
      <a-input
        v-decorator="[
          'title',
          {initialValue:chefeCV.title, rules: [{ required: true, message: 'Please input your title!' }] },
        ]"
        placeholder="Title"
        allow-clear
      >
      </a-input>
    </a-form-item>

    <a-form-item label="Details" :validate-status="summaryError() ? 'error' : ''" :help="summaryError() || ''">
      <a-textarea 
        placeholder="Details about the meal" 
        :rows="2"
        v-decorator="[
          'summary',
          {initialValue:chefeCV.summary, rules: [{ required: true, message: 'Please input your summary discription!' }] },
        ]" 

        allow-clear

      />
    </a-form-item>

    <a-form-item label="Experience" :validate-status="experienceError() ? 'error' : ''" :help="experienceError() || ''">
      <a-select
        v-decorator="[
          'experience',
          {initialValue:chefeCV.experience, rules: [{ required: true, message: 'Please input your experience!' }] },
        ]"
        placeholder="Select Experience"
      >
        <a-select-option v-for="experience in experiences"  v-bind:value="experience.id" :key="experience.id" >
          ({{ experience.ref }}) {{ experience.title }} - {{ experience.description }}
        </a-select-option>
      </a-select>
    </a-form-item>

    <a-form-item label="Common Timing" :validate-status="experienceError() ? 'error' : ''" :help="experienceError() || ''">
      <a-select
        v-decorator="[
          'experience',
          {initialValue:chefeCV.experience, rules: [{ required: true, message: 'Please input your experience!' }] },
        ]"
        placeholder="Select Experience"
      >
        <a-select-option v-for="commonTiming in commonTimings"  v-bind:value="commonTiming.id" :key="commonTiming.id" >
          {{ commonTiming.common_timing }}
        </a-select-option>
      </a-select>
    </a-form-item>


    <a-form-item label="Time"  >
     <a-time-picker :minute-step="15" :second-step="10"
      v-decorator="[
      'time',
          {
            rules: [{ required: true, message: 'Please input a Time!' }],
          },
        ]"
      />
    </a-form-item>


    <a-form-item label="People"  >

    <a-row>
      <a-col :span="12">
        <a-slider v-model="inputValue1" :min="1" :max="50"

         />
      </a-col>
      <a-col :span="4">
        <a-input-number v-model="inputValue1" :min="1" :max="50" style="marginLeft: 16px" 
   
        />
      </a-col>
    </a-row>
    </a-form-item>



    <a-form-item label="Ingredients">
      <template>
        <a-select mode="tags" style="width: 100%" placeholder="Select Ingredients" @change="handleingreChange"

          v-decorator="[
          'ingredients',
              {
                rules: [{ required: true, message: 'Please input Ingredients !' }],
              },
            ]"
          />
        
          <a-select-option v-for="i in 25" :key="(i + 9).toString(36) + i">
            {{ (i + 9).toString(36) + i }}
          </a-select-option>
        </a-select>
      </template>
    </a-form-item>

    <a-form-item label="Tags">
      <template v-for="tag in tags">
        <a-checkable-tag
          :key="tag"
          :checked="selectedTags.indexOf(tag) > -1"
          @change="checked => handletagChange(tag, checked)"
        >
          {{ tag }}
        </a-checkable-tag>
      </template>
    </a-form-item>

    <a-form-item >
      <a-col :xs="{ span: 24, offset: 0}" :lg="{ span: 20, offset: 10}"> 
          <a-button icon="check-circle"  type="primary" html-type="submit" :disabled="hasErrors(form.getFieldsError())" >
              Save
          </a-button >
          <a-button icon="plus"  type="primary" >
              Price
          </a-button >
      </a-col>
    </a-form-item>
  </a-row>
  </a-form>
</template>

<script>

function getBase64(img, callback) {
  const reader = new FileReader();
  reader.addEventListener('load', () => callback(reader.result));
  reader.readAsDataURL(img);
}
function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
export default {
  data() {
    return {
      inputValue: 0,
      inputValue1: 1,
      loading: false,
      imageUrl: '',
      hasErrors,
      formLayout: 'horizontal',
      form: this.$form.createForm(this, { name: 'coordinated' }),
      experiences:'',
      fileInfo:'',
      userInfo: localStorage.getItem('user'),
      userID: '',
      chefeCV: '',
      commonTimings: '',
      currencys: '',
      tags: ['Beef', 'Tomato Sauce', 'eggs'],
      selectedTags: [],
    };
  },
  mounted() {
    this.$nextTick(() => {
      // To disabled submit button at the beginning.
      this.form.validateFields();
    });
  },
  methods: {
    handleingreChange(value) {
      console.log(`selected ${value}`);
    },
    handletagChange(tag, checked) {
      const { selectedTags } = this;
      const nextSelectedTags = checked
        ? [...selectedTags, tag]
        : selectedTags.filter(t => t !== tag);
      console.log('You are interested in: ', nextSelectedTags);
      this.selectedTags = nextSelectedTags;
    },
    handleChange(info) {
      if (info.file.status === 'uploading') {
        this.loading = true;
        return;
      }
      if (info.file.status === 'done') {
        this.fileInfo=info.file.response;
        // Get this url from response in real world.
        getBase64(info.file.originFileObj, imageUrl => {
          this.imageUrl = imageUrl;
          this.loading = false;
        });
      }
    },
    beforeUpload(file) {
      const isJpgOrPng = file.type === 'image/jpeg' || file.type === 'image/png';
      if (!isJpgOrPng) {
        this.$message.error('You can only upload JPG file!');
      }
      const isLt2M = file.size / 1024 / 1024 < 10;
      if (!isLt2M) {
        this.$message.error('Image must smaller than 10MB!');
      }
      return isJpgOrPng && isLt2M;
    },
    handleConfirmBlur(e) {
      const value = e.target.value;
      this.confirmDirty = this.confirmDirty || !!value;
    },

    // Only show error after a field is touched.
    titleError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('title') && getFieldError('title');
    },
    summaryError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('summary') && getFieldError('summary');
    },
    experienceError() {
      const { getFieldError, isFieldTouched } = this.form;
      return isFieldTouched('experience') && getFieldError('experience');
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
      .post("create/cv", { data: { cvDate: data, fileData:this.fileInfo} })
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
      .get('getExperiences')
      .then(response => (this.experiences = response.data));
  axios
      .get('getCommonTiming')
      .then(response => (this.commonTimings = response.data));   
  axios
      .get('getTimeCurrency')
      .then(response => (this.currencys = response.data));

  axios
      .get('getCVData/'+this.userID)
      .then(response => (this.chefeCV = response.data,this.imageUrl = 'storage/'+response.data.picture.path+response.data.picture.name));
  },
};
</script>
<style>
.avatar-uploader > .ant-upload {
  width: 128px;
  height: 128px;
}
.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}

.picture_avatar {
  width: 200px;
  height: 200px;
}
<style scoped>
.code-box-demo .ant-slider {
  margin-bottom: 16px;
}
</style>

