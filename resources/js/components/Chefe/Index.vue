<template>
<div>
    <v-tabs
    v-model="tab"
    >
      <v-tab href="#tab-1">About</v-tab>
      <v-tab href="#tab-2">Experience</v-tab>
      <v-tab href="#tab-3">School</v-tab>
      <v-tab href="#tab-4">References</v-tab>
      <v-tab href="#tab-5">Certificates and attachments</v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab" class="pt-4">
        <v-tab-item
            :key="1"
            :value="'tab-' + 1"
        >
        <CV />
        </v-tab-item>        
        <v-tab-item
            :key="2"
            :value="'tab-' + 2"
        >
        <Experience/>
        </v-tab-item>    
        <v-tab-item
            :key="3"
            :value="'tab-' + 3"
        >
        <School />
        </v-tab-item>    
        <v-tab-item
            :key="4"
            :value="'tab-' + 4"
        >
        <Contact />
        </v-tab-item>  
        <v-tab-item
            :key="5"
            :value="'tab-' + 5"
        >
        <Files />
        </v-tab-item>
    </v-tabs-items>
          
</div>
</template>
<script>
  import CV from './CV.vue';
  import Experience from './Experience.vue';
  import School from './School.vue';
  import Contact from './Contact.vue';
  import Files from './Files.vue';
export default {
    components: { CV,Experience,School,Contact,Files},
    data() {
        return {
            tab:null,

        }
    },
    methods: {

        },
    mounted() {
     
    },
        
    watch: {
    }
}
</script>