<template>
<div>
    <v-tabs
    v-model="tab"
    >
      <v-tab href="#tab-1">About</v-tab>
      <v-tab href="#tab-2">Experience</v-tab>
      <v-tab href="#tab-3">School</v-tab>
      <v-tab href="#tab-4">References</v-tab>
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
    </v-tabs-items>
          
</div>
</template>
<script>
  import CV from './CV.vue';
  import Experience from './Experience.vue';
  import School from './School.vue';
  import Contact from './Contact.vue';
export default {
    components: { CV,Experience,School,Contact},
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