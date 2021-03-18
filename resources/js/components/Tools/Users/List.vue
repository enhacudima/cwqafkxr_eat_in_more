<template>
    <div>  
    <v-col cols="12" dense>  
        <v-server-table url="getUsersList" :columns="columns" :options="options">
            
            <div slot="status" slot-scope="props">
                    <v-btn
                    small
                    outlined
                    color="red"
                    v-if="props.row.email_verified_at === null"
                    >
                    <v-icon small>mdi-check</v-icon>
                    Not verified
                    </v-btn>
                    <v-btn
                    small
                    outlined
                    color="green"
                    v-else-if="props.row.status === 1"
                    >
                    <v-icon small>mdi-check-all</v-icon>
                    Active
                    </v-btn>
                    <v-btn
                    small
                    outlined
                    color="pink"
                    v-else-if="props.row.status === 0 "
                    >
                    <v-icon small>mdi-fire</v-icon>
                    Suspended
                    </v-btn>
            </div>

            <div slot="email_verified_at" slot-scope="props">
                {{formatBrithDate(props.row.email_verified_at)}}
            </div>
            <div slot="dataBrith" slot-scope="props">
                {{formatBrithDate(props.row.dataBrith)}}
            </div>
            <div slot="updated_at" slot-scope="props">
                {{formatDate(props.row.updated_at)}}
            </div>
            <div slot="child_row" slot-scope="props">
                <div><b>Chef Type:</b> {{ props.row.title}}</div>
            </div>
            <div slot="user_type" slot-scope="props">
                <v-btn
                small
                outlined
                color="red"
                v-if="props.row.type === 1 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="green"
                v-if="props.row.type === 2 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="pink"
                v-if="props.row.type === 3 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
            </div>
        </v-server-table>
    </v-col>
    
    
    <v-dialog
      v-model="dialogType"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="priceForm" v-model="valid" lazy-validation>
        <v-card-title>
          <span class="headline">Update User</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formList.commets"
                  label="Comments*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
            <v-col cols="12">                     
              <v-autocomplete
                v-model="formList.type"
                :items="userType"
                label="Type"
                item-text="type"
                item-value="id"
                return-object
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="12">                     
              <v-autocomplete
                v-model="formList.userStatus"
                :items="userStatus"
                label="Status"
                item-text="name"
                item-value="id"
                return-object
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="12">                     
              <v-autocomplete
                v-model="formList.chefType"
                :items="experiences"
                label="Chef Type"
                :item-text="item => '('+item.ref+')' + item.title + ' - '+ item.description"
                item-value="key"
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
            @click="dialogType = false"
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

    </div>
     
</template>


<script>
    
    export default {
        
        mounted() {
        axios
            .get('getExperiencesActive')
            .then(response => (this.experiences = response.data));
        },
         methods: {
            onUpdate() {
             this.$refs.table.refresh();
            },
            formatDate(date) {
              return moment(date).format('DD-MM-YYYY HH:mm:ss');
            },
            formatBrithDate(date) {
              return moment(date).format('DD-MM-YYYY');
            },
            openUserType(key){
                this.userKey = key;
                this.dialogType=true;
            },
        validate() {
        if (this.$refs.priceForm.validate()) {
            // submit form to server/API here...
            //console.log(this.formReg);
            this.sendData(this.formList);
            this.dialogType = false;
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
        .post("tools/users/update/"+this.userKey, { data: { userData: data} })
        .then(response => {
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

        data() {
            return {
                userKey:null,
                experiences:[],
                rules: {
                required: value => !!value || "Required.",
                },
                valid: true,
                formList:{
                    commets:null,
                    type:null,
                    chefType:null,
                    userStatus:null,

                },
                userType:[
                    {type:"Admin",id:"1"},
                    {type:"Client",id:"2"},
                    {type:"Chef",id:"3"}
                ],
                
                userStatus:[
                    {name:"Suspended",id:"0"},
                    {name:"Active",id:"1"},
                ],
                dialogType:false,
                columns: ["id","name",	"lastName","dataBrith","prefix_phone_1","phone1","updated_at","email_verified_at","user_type","status"],
                tableData: [],
                options: {
                headings: {
                        codigo: 'Name',
                        lastName: 'Last_Name',
                        dataBrith: 'Data_Brith',
                        prefix_phone_1: '',
                        phone1: 'Phone',
                        updated_at: 'Last_update',
                        type: 'Type',
                        status: 'Status',
                        email_verified_at: 'Verified',
                        
                    },
                    filterable: ["id","name",	"lastName","dataBrith","prefix_phone_1","phone1","updated_at","user_type","status","email_verified_at"],
                    filterByColumn: true,
                    orderBy: { column: 'updated_at'},
                    setOrder: { ascending:true},
                    uniqueKey: 'id',
                    listColumns: {
                    },
      
                
                perPage: 12,
                perPageValues:[12,25, 50, 75,100,250,500,1000],
            }
        };
    },
    }

</script>


<style>
.table thead th {
    padding: 0.3rem;
    padding-top: 0.3rem;
    padding-right: 0.3rem;
    padding-bottom: 0.3rem;
    padding-left: 0.3rem;
    font-size: 12px;
}
.table tbody td {
    padding: 0.3rem;
    padding-top: 0.3rem;
    padding-right: 0.3rem;
    padding-bottom: 0.3rem;
    padding-left: 0.3rem;
    font-size: 12px;
}
</style>
