<template>
    <div id="page-sidebar" ref="sidebar">
        <div id="profile" v-on:mouseenter="profilePicChange">
            <img id="profile-picture" src="../assets/images/Olga_bewerbung.jpg" alt="Profilblid Olga Hedderich"/>
            <div id="unicorn-wrapper" v-bind:style="styleObject" >
                <img id="unicorn-head" src="../assets/images/unicorn.svg" alt="Einhorn Overlay" />
            </div>
        </div>
        <div id="menu-title">
            {{menuHeader}}
        </div>
            <mq-layout mq="sm" id="page-menu">
                <a v-for="l in links" :href="'#'+l.id" :key="l.id" @click="toggleMenuBar()">{{l.name}}</a>
            </mq-layout>
            <mq-layout mq="lg" id="page-menu">
                <a v-for="l in links" :href="'#'+l.id" :key="l.id" v-scroll-to="'#'+l.id">{{l.name}}</a>
            </mq-layout>
    </div>
</template>

<script>


var anime = require('../plugins/anime.min.js');
export default {
  name: 'sidebar',
  props: ['links','usedOverlayID','menuHeader'],
  data () {
    return {
        styleObject: {
            opacity : 0
        },
        negate_opacity : false,
        menuBarToggler : {
            animations: {
                openMenuAnimation: {
                    animation: null, //will be animation
                    paramVal: 0
                },
                closeMenuAnimation: {
                    animation: null, //will be animation
                    paramVal: 1
                }
            },
            menuBarShow: false,
            targetVals: {
                overlay: this.usedOverlayID,
                sidebar: '#page-sidebar'
            },
            animationVals: [
                {
                    translateVal: null, //will be set in mounted hook
                    opacVal: [0,0.7],
                    offset: '-=1500',
                    easing: 'easeInQuad',
                    durationSidebar: 1250,
                    durationOverlay: 2000,
                    finishedFunction: function () { },
                    beginFunction: function () { this.emitOverlayEvent(false);}.bind(this)
                },
                {
                    translateVal: null, //will be set in mounted hook
                    opacVal: [0.7,0],
                    offset: '-=2000',
                    easing: 'easeOutQuad',
                    durationSidebar: 2500,
                    durationOverlay: 2000,
                    beginFunction: function () { },
                    finishedFunction: function () { this.emitOverlayEvent(true); }.bind(this)
                }
            ],
        }
    }
  }, mounted(){
      //set this value dynamically as soon as component is mounted to get actual value set in CSS
      this.menuBarToggler.animationVals[0].translateVal = ['-'+this.$refs.sidebar.offsetWidth,0];
      this.menuBarToggler.animationVals[1].translateVal = [0,'-'+this.$refs.sidebar.offsetWidth];
      
      this.$bus.$on('menuAnimationEvent',this.toggleMenuBar);
  },
  methods: {
      profilePicChange: function () {
        if (!this.negate_opacity) { this.styleObject.opacity = this.styleObject.opacity + 0.2; }
        else { this.styleObject.opacity = this.styleObject.opacity - 0.1; }
        if (this.styleObject.opacity > 0.9) { this.negate_opacity = true; }
        else if (this.styleObject.opacity < 0.2) { this.negate_opacity = false; }
    },
    emitOverlayEvent: function(IsHidden) {
        if(typeof IsHidden == "boolean"){
            this.$bus.$emit('overlayEvent',IsHidden);
        }else{
            throw "Parameter type must be boolean";
        }
      
    },
    toggleMenuBar: function() {
        var closeAnim = !this.menuBarToggler.animations.closeMenuAnimation.animation ? this.createMenuBarAnimation(this.menuBarToggler.animations.closeMenuAnimation) : this.menuBarToggler.animations.closeMenuAnimation;
        var openAnim = !this.menuBarToggler.animations.openMenuAnimation.animation ? this.createMenuBarAnimation(this.menuBarToggler.animations.openMenuAnimation) : this.menuBarToggler.animations.openMenuAnimation;

        if (!this.menuBarToggler.menuBarShow) {
            this.menuBarToggler.menuBarShow = true;
            closeAnim.animation.pause();
            openAnim.animation.restart();
        } else {
            this.menuBarToggler.menuBarShow = false;
            openAnim.animation.pause();
            closeAnim.animation.restart();
        }
    },
    createMenuBarAnimation: function(animatableElement){
        animatableElement.animation = anime.timeline({ autoplay: false });
        var animationValueKey= animatableElement.paramVal;
        animatableElement.animation.
        add({
            targets: this.menuBarToggler.targetVals.overlay,
            opacity: this.menuBarToggler.animationVals[animationValueKey].opacVal,
            duration: this.menuBarToggler.animationVals[animationValueKey].durationOverlay,
            begin: this.menuBarToggler.animationVals[animationValueKey].beginFunction,
            complete: this.menuBarToggler.animationVals[animationValueKey].finishedFunction
        }).add({
            targets: this.menuBarToggler.targetVals.sidebar,
            translateX: this.menuBarToggler.animationVals[animationValueKey].translateVal,
            easing: this.menuBarToggler.animationVals[animationValueKey].easing,
            duration: this.menuBarToggler.animationVals[animationValueKey].durationSidebar,
            offset: this.menuBarToggler.animationVals[animationValueKey].offset,
            elasticity: 0
        });
        return animatableElement;
    }
  }
}
</script>

<style lang="scss">
@import "../styles/settings.scss";
@import "../assets/fonts/fontsheet.css";
#page-sidebar{
	text-align: center;
	background-color: $secondary-background-color;
	box-shadow: 0.2em -0.1em 0.4em 0em $shadow-color;
    overflow-y: auto;
    border-radius: 0em 1.5em 1.5em 0em;
    z-index: 10;
}

#page-sidebar a{
    color: $heading-color;
    font-size: 0.8em;
}

#menu-title {
    padding: 1.5em 0;
    font-weight: bold;
    color: $heading-color;
    margin: 0 1rem;
    font-size: 1.15rem;
    border-radius: 0.25rem;
    background-color: $heading-background-color;
}

#page-menu{
	display: flex;
    flex-direction: column;
    padding: 1em;
    height: 65%;
    justify-content: space-around;
}

#page-menu a {
    padding: 1.5em 0;
    border-bottom-style: solid;
    border-bottom-width: 0.15em;
    text-decoration: none;
    background-color: $action-color;
    border-radius: 0.25rem;
    margin-top: 0.5rem;
}

#profile{
    position: relative;
    overflow: hidden;
    width: 8em;
    height: 8em;
    display: inline-block;
    margin: 2em 0;
}

#profile-picture{
    position: absolute;
    left: 50%;
    top: 50%;
    height: auto;
    width: 100%;
    transform: translate(-50%, -43%);
}

#unicorn-head{
	position: absolute;
	top: 0.5em;
	left: 0.5em;
	height:7em;
	width: 7em;
	z-index:3;
}

#unicorn-wrapper{
	position: absolute;
	height:8em;
	width:8em;
	z-index:2;
	background-color: white;
	opacity: 0;
}

@media screen and (max-width: 800px) {
    #page-sidebar{
        transform: translateX(-$mobile-sidebar-grid);
        z-index: 100;
    }
}

@media print{
    #page-sidebar {
        display: none;
    }
}

</style>
