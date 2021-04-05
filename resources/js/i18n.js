
import Vue from 'vue';
import VueI18n from 'vue-i18n';

Vue.use(VueI18n);


const messages = {
    'en': {
        login:'Sign in to start your session',
        search:'Search',
        welcome:'Welcome',
        about_us:'About Us',
        contact:'Contact',
        terms_and_conditions:'Terms and Condictions',
        cusine:'Cuisine',
        common_timing:'Common timing',
        type:'Type',
        allergies:'Allergies',
    },
    'pt_BR': {
        login:'Faça login para iniciar sua sessão',
        search: 'Pesquisa',
        welcome: 'Bem Vindo',
        about_us:'Acerca de nós',
        contact:'Contactos',
        terms_and_conditions:'Termos e condições',
        cusine:'Culinária',
        common_timing:'Servido em',
        type:'Tipo',
        allergies:'Alergias',
    }
};

const i18n = new VueI18n({
    locale: 'en', // set locale
    fallbackLocale: 'pt_BR', // set fallback locale
    messages, // set locale messages
});

export {i18n};
