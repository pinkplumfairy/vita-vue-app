<template>
    <div class="vita_knowledge">
        <h3>{{skills.name}}</h3>
        <div class="knowledge_set" v-for="i in skills.values" v-bind:key="i.id">
            <div class="knowledge_set_left">{{i.text}}</div>
            <div class="bar_inside">
                <div class="knowledge_bar">
                    <div class="top_knowledge_bar" :class=i.level ></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var anime = require('../../plugins/anime.min.js');

export default {
  name: 'knowledge',
  props: ['skills'],
  data () {
    return {
    }
  }
}
</script>

<style lang="scss">
@import "../../styles/settings.scss";

.vita_knowledge{
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin: 1em 0em;
}

.knowledge_set{
    display: flex;
    width: 60vw;
    flex-wrap: nowrap;
    justify-content: center;
    margin: 0.5em 0em;
}

.knowledge_set_left{
    width: 20vw;
}

.tooltip{
	background-color: $heading-background-color;
	font-size: 0.85em;
    height: 1em;
    position: absolute;
    line-height: 0.85em;
    padding-top: 0.15em;
    padding-left: 0.15em;
    box-shadow: 0.1em 0.1em 0.2em $shadow-color;
    width: 15em;
}

.knowledge_bar, .top_knowledge_bar {
    height: 1em;
}

.knowledge_bar {
    background-color: $light-action-color;
    z-index: 1;
}

.top_knowledge_bar {
    background-color: $action-color;
    z-index: 2;
}

.bar_inside {
    height: 1em;
    width: 20vw;
}

.hundred_percent {
    width: 100%;	
}

.eighty_percent {
    width: 80%;	
}

.sixty_percent {
    width: 60%;	
}

.forty_percent {
    width: 40%;	
}

.twenty_percent {
    width: 20%;	
}

@media screen and (max-width: 800px){
    .knowledge_set{
        width: 60vw;
        flex-wrap: wrap;   
    }

    .knowledge_set_left, .bar_inside{
        width: 60vw;
    }
}

</style>