<template>
        
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
                <div><b>Tipo:</b> {{ props.row.tipodecliente}}</div>
            </div>
            <div slot="user_type" slot-scope="props">
                <v-btn
                small
                outlined
                color="red"
                v-if="props.row.type === 1 "
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="green"
                v-if="props.row.type === 2 "
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="pink"
                v-if="props.row.type === 3 "
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
            </div>
        </v-server-table>
    </v-col>
     
</template>


<script>
    
    export default {
         methods: {
            onUpdate() {
             this.$refs.table.refresh();
            },
            formatDate(date) {
              return moment(date).format('DD-MM-YYYY HH:mm:ss');
            },
            formatBrithDate(date) {
              return moment(date).format('DD-MM-YYYY');
            }
        },

        data() {
            return {

                columns: ["id","name",	"lastName","dataBrith","prefix_phone_1","phone1","updated_at","email_verified_at","user_type","status"],
                tableData: [],
                options: {
                headings: {
                        codigo: 'Name',
                        lastName: 'Last Name',
                        dataBrith: 'Data Brith',
                        prefix_phone_1: '',
                        phone1: 'Phone',
                        updated_at: 'Last update',
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
    width: 100px;
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
