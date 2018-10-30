<template>
<div id="page">
    <div class="apiMessage" v-if="apiErrorHandling.showingCachedVersion | apiErrorHandling.errorDetails !== null | apiErrorHandling.dataFetchError">
        <div class="apiWarning" v-if="apiErrorHandling.showingCachedVersion">You are seeing the cached version of this site. You are probably offline.</div>
        <div class="apiError" v-if="apiErrorHandling.errorDetails !== null">Error Details from PHP: {{apiErrorHandling.errorDetails}}</div>
        <div class="apiError" v-if="apiErrorHandling.dataFetchError">Sorry, there was an error fetching the required data. Please contact the site administrator</div>
    </div>
    <div id="inner-page">
        <div :id="overlayProps.ID" v-bind:style="overlayProps.style">
            <img class="menu_buttons" id="xbutton" src="./assets/images/x_button.svg" alt="Close Button" @click="toggleMenu" />
        </div>
        <app-sidebar :links="menuItems" :usedOverlayID="'#'+overlayProps.ID" :menuHeader="menuLabel"></app-sidebar>
        <div id="page-header">
            <div><img class="menu_buttons" id="menubutton" src="./assets/images/menu_button.svg" alt="Menu Button" @click="toggleMenu" /></div>
            <h1 id="page-title">{{headingLabel}}</h1>
            <div id="page-madewith"><p>Proudly made with VUE</p></div>
            <div><img id="page-madewith-logo" src="./assets/images/Vue.js_Logo.svg" alt="Vue Logo" /></div>
        </div>
        <div id="content-wrapper">
            <app-vita v-for="(item, key) in vitaItems" :singlevita="item" :itemid="key" :key="item.id"></app-vita>
        </div>      
    </div>               
</div>
</template>

<script>

import Sidebar from './components/sidebar.vue';
import VitaItem from './components/vita/vita-item.vue';
import {HTTP} from './main.js';


export default {
  components: {
      'app-sidebar': Sidebar,
      'app-vita': VitaItem
  },
  name: 'App',
  data () {
    return {
        vitaItems: [],
        menuItems: [],
        headingLabel: '',
        menuLabel: '', 
        apiErrorHandling: {
            dataFetchError: false,
            showingCachedVersion: false,
            errorDetails: null
        },
        overlayProps: {
            ID: 'overlay',
            style: 
            {
                display: 'none'
            }
        }
    }
  },
  created(){
    
    var version = localStorage.getItem('version');

    if(version == null) version = "null";
    HTTP.get("php/index.php", {
        params: {
            version: version
        }
    }).then(response => 
    {
        if(response.data.result === 'noupdate'){
            this.getDataFromLocalStorage();
        }else if(response.data.result === 'update'){
            this.writeDataToLocalStorage(response);
            this.getDataFromLocalStorage();
        }else{
            console.log(response);
            this.apiErrorHandling.errorDetails = response.data;
            throw "PHP returned result: "+response.data.result;
        }
    }
    ).catch(error => 
        {
            if(version !== "null")
            {
                this.getDataFromLocalStorage();
                this.apiErrorHandling.showingCachedVersion = true;
            }else{
                this.apiErrorHandling.dataFetchError = true;
            }
            console.error(error);
            return;
        }
    );
  }, mounted(){
      this.$bus.$on('overlayEvent', this.toggleOverlay);

  },
  methods:{
      toggleOverlay: function(IsHidden){
          IsHidden ? this.overlayProps.style.display = 'none' : this.overlayProps.style.display = 'block';
      },
      toggleMenu: function(){
          this.$bus.$emit('menuAnimationEvent');
      },
      getMenuItems: function (inputList) {
          var menuItems = [];
          for (const key in inputList) {
              if (inputList.hasOwnProperty(key)) {
                  const objText = inputList[key].text;
                  menuItems.push({id:key,name:objText});
              }
          }
          return menuItems; 
      },
      getDataFromLocalStorage: function (){
        this.vitaItems = JSON.parse(localStorage.getItem('vita'));
        this.menuItems = this.getMenuItems(this.vitaItems);
        this.headingLabel = localStorage.getItem('header');
        this.menuLabel = localStorage.getItem('menu');
      },
      writeDataToLocalStorage: function(response){
        localStorage.setItem('vita', JSON.stringify(response.data.data.vita));
        localStorage.setItem('version',response.data.version);
        localStorage.setItem('header',response.data.data.heading);
        localStorage.setItem('menu',response.data.data.menu);
      }
  }
}
</script>
<style lang="scss">
@import "./styles/settings.scss";
@import "./assets/fonts/fontsheet.css";
html, body{
    height:100%;
    margin: 0;
}

.apiMessage{
    background: $inverted-background-color-w-opacity;
    color: $main-background-color;
    font-family: $content-font;
    padding: 1em 0em;
    position: absolute;
    width: 100%;
    text-align: center;
    z-index: 100;
}

.apiError{
    color: $error-color;
    font-weight: bold;
}

#inner-page{
	margin: 0;
	font-family: $content-font;
    display: grid;
    color: $font-color;
    background-color: $main-background-color;
    grid-template-columns: [sidebar] 15vw [page-content] 80vw;
    grid-template-rows: [header] 10vh [page-content] 90vh;
    grid-column-gap: 5vw;
    max-height: 100vh;
}

#page-sidebar {
    grid-column: sidebar / page-content;
    grid-row: header / 3;
}

#content-wrapper{
    grid-column: page-content / 3;
    grid-row: page-content;
    max-height: 100vh;
    overflow-y: scroll;
}

#page-header {  
    background-color: $heading-background-color;
    border-bottom-style: solid;
    border-color: $heading-color;
    box-shadow: 0em 0.5em 0.7em $shadow-color;
    grid-row: header / page-content;
    grid-column: sidebar / 3;
    display: grid;
    grid-template-columns: [button] 30vw [heading] 55vw [madewith] 10vw [madelogo] 5vw;
}

#page-header .menu_buttons{
    grid-column: button;
}

#page-title{
    grid-column: heading;
    text-align: center;
}

#page-madewith{
    grid-column: madewith;
    font-weight: bold;
    text-align: center;
}

#page-madewith > p{
    margin: 0;
}

#page-madewith-logo{
    grid-column: madelogo;
    width: 100%;
}

h1, h2, h3, h4 ,h5, h6{
	font-family: $heading-font;
	color: $heading-color;
}

a {
    color: $action-color;
    font-weight: bold;
}

.menu_buttons, #overlay {
    display: none;
}

#page-header > div {
    display: flex;
    justify-content: space-around;
    flex-direction: column;
}

@media print {

    a[href*='//']:after {
        content:" (Original Link: " attr(href) ") ";
    }

    #page-content {
        margin: 0;
    }

    h1, h2, h3, h4, h5, h6, #page-header {
        font-family: $heading-font !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    a {
        page-break-inside: avoid;
        display: block;
    }

    #inner-page{
        grid-template-columns: [sidebar] 0vw [page-content] 100vw;
        grid-template-rows: [header] 10vh [page-content] 90vh;
        grid-column-gap: 0vw;
        max-height: unset;
    }

    #content-wrapper{
        grid-column: page-content / 3;
        grid-row: page-content;
        max-height: unset;
        overflow-y: unset;
    }
    #page-header {  
        grid-template-columns: [button] 25vw [heading] 50vw [madewith] 20vw [madelogo] 5vw;
    }

    #page-madewith, #page-madewith > p, #page-madewith-logo, .apiMessage{
        display: none;
    }
}

@media screen and (max-width: 800px) {
    #inner-page{
        grid-template-columns: [sidebar] $mobile-sidebar-grid [page-content] 30vw;
        grid-column-gap: 0;
    }

    #page-header{
        grid-template-columns: [button] 10vw [heading] 70vw [madewith] 10vw [madelogo] 10vw;
    }

    #menubutton {
        width: 80%;
        margin: 0% 10%;
        display: block;
    }

    #xbutton {
        width: 3em;
        position: fixed;
        top: 1em;
        right: 1em;
        display: block;
    }

    #overlay {
        width: 100%;
        height: 100%;
        opacity: 0.7;
        background-color: $shadow-color;
        position: fixed;
        z-index: 50;
    }

    #content-wrapper {
        grid-column: sidebar / 3;
    }
}

@media screen and (max-width: 450px){
    #page-header {
        grid-template-columns: [button] 18vw [heading] 55vw [madewith] 17vw [madelogo] 10vw;
    }

    #page-madewith{
        font-size: 0.65em;
    }

}
</style>
