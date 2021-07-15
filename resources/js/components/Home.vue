<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    sort-by="calories"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Pending requests</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-autocomplete
                        v-model="editedItem.status"
                        :items="status"
                        label="Status"
                        item-text="name"
                        item-value="id"
                    >
                    </v-autocomplete>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Cancel
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                Save
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        color="green"
        x-small
        v-if="item.status==='3'"
        >
            Accepted
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status==='4'"
        >
            Pending payment
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status==='5'"
        color="green"

        >
            Payment accepted
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status==='6'"
        color="green"
        >
            Confirmed service
        </v-chip>
        <!--duplocate-->
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        color="green"
        x-small
        v-else-if="item.status===3"
        >
            Accepted
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status===4"
        >
            Pending payment
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status===5"
        color="green"

        >
            Payment accepted
        </v-chip>
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else-if="item.status===6"
        color="green"
        >
            Confirmed service
        </v-chip>
        <!--end duplicate-->
        <v-chip
        @click="editItem(item)"
        class="ma-2"
        x-small
        v-else
        >
            Pending
        </v-chip>
        <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-eye-plus
      </v-icon>
    </template>

    <template v-slot:item.title="{ item }">
        <v-chip
        class="ma-2"
        x-small
        >
            {{item.title}}
        </v-chip>
    </template>

    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialise"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>


<script>
  export default {
    data: () => ({
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Last Update',
          align: 'start',
          //sortable: false,
          value: 'updated_at',
        },
        { text: 'Date', value: 'cook_start_date' },
        { text: 'Time', value: 'Cook_start_time' },
        { text: 'Address', value: 'full_address' },
        //{ text: 'Type of stove', value: 'type_stove_power_source' },
        //{ text: 'Stove backup', value: 'stove_backup' },
        //{ text: 'Grill', value: 'grill_available' },
        { text: 'Category', value: 'title' },
        { text: 'Key', value: 'key' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      desserts: [],
      editedIndex: -1,
      editedItem: {
        status: 2,
      },
      defaultItem: {
        status: 2,
      },
      listPrimitive: null,
      requestList:[],
        status:[
            {name:"Not Accepted",id:"2"},
            {name:"Accepted",id:"3"},
        ],
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Accept Request'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      //this.getrRequests()
    },

    methods: {

        initialise(hamoni) {
            axios
            .get('booking/GetRequests')
            .then(response => (
                this.requestList = response.data,
                hamoni.createList("vue-table",
                    this.requestList
                ).then(primitive => {
                    this.listPrimitive = primitive
                    this.desserts = this.listPrimitive.getAll()
                    this.subscribeToUpdate();
                }).catch(error => console.log(error))


            ));

        },


    subscribeToUpdate() {
        this.listPrimitive.onItemAdded(item => {
            this.desserts.push(item.value)
        })

        this.listPrimitive.onItemUpdated(item => {
        //update the item at item.index
            this.desserts.splice(item.index, 1, item.value);
        })

        this.listPrimitive.onItemRemoved(item => {
        //remove the item at item.index
            this.desserts.splice(item.index, 1);
        })
    },

        getrRequests (){
             axios
                .get('booking/GetRequests')
                .then(
                    response => (
                        this.listPrimitive.set(response.data)
                    )
                );
        },
      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.desserts.splice(this.editedIndex, 1)
        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        //verify if user have permission to update
        axios
        .post('booking/confirm-chef-booking',{ data: this.editedItem })
         .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error: ', error);});

          } else {
            this.saveAction(response.data)
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
                errors.forEach(error => { this.openNotification('error', 'Error: ', error);});
            }else{
                this.openNotification('error','Error: ',error);
            }
        });

      },

      saveAction (response){
        if (this.editedIndex > -1) {
          //Object.assign(this.desserts[this.editedIndex], this.editedItem)
          this.listPrimitive.update(this.editedIndex, this.editedItem)
        } else {
          //this.desserts.push(this.editedItem)
          this.listPrimitive.add(this.editedItem)
        }
        this.listPrimitive.set(response)
        this.close()

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

    mounted: function () {
        const accountId = "c4c241b7-22fb-4223-a52e-b245e042f3b7";
        const appId = "ee9efb62977449b094911ac8e5eb6039";
        let hamoni;

        fetch("https://api.sync.hamoni.tech/v1/token", {
            method: "POST",
            headers: {
            "Content-Type": "application/json; charset=utf-8"
            },
            body: JSON.stringify({ accountId, appId })
        }).then(response => {
            response.json().then(token => {
            hamoni = new Hamoni(token);

            hamoni.connect().then(() => {
            hamoni.get("vue-table").then(primitive => {
                this.listPrimitive = primitive
                this.desserts = [...primitive.getAll()]
                //this.listPrimitive.onItemUpdated( item => alert("New updates available"))
                axios
                .get('booking/GetRequests')
                .then(response => (
                    //primitive.set(response.data),
                    this.desserts = response.data,
                    this.subscribeToUpdate()
                ));
            }).catch(error => {
                if (error === "Error getting state from server")
                this.initialise(hamoni);
                else
                alert(error)
            })
            }).catch(alert)
            })
        })
    },
  }
</script>
