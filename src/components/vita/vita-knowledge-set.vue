<template>
    <div class="knowledge_set" >
        <div v-if="activateMouseOver" v-on:mouseenter="toggleKnowledgebarDesc(true)" @mouseout="toggleKnowledgebarDesc(false)" class="knowledge_set_left">{{set.text}}</div>
        <div v-else class="knowledge_set_left" >{{set.text}}</div>
        <div class="bar_inside" >
            <div class="knowledge_bar">
                <div class="top_knowledge_bar" :class="set.level" >
                    <div v-if="activateMouseOver" :class="knowledge_desc_classes" class="knowledge_bar_description" @mouseenter="toggleKnowledgebarDesc(true)" @mouseout="toggleKnowledgebarDesc(false)">
                        {{set.description}}
                    </div>
                    <div v-else class="knowledge_bar_description show">{{set.description}}</div>
                </div>
            </div>
        </div>
        </div>
</template>
<script>
export default {
    name: 'knowledge-set',
    props: ['set'],
    data (){
        return {
            knowledge_desc_classes: {
                hide: true,
                show: false
            }
        }
    },
    computed: {
        activateMouseOver() {
            return this.$mq === 'lg' ? true : false
        }
    },
    methods: {
        toggleKnowledgebarDesc: function(IsVisible){
            this.knowledge_desc_classes.hide = IsVisible ? false : true;
            this.knowledge_desc_classes.show = IsVisible ? true : false;
        }
    }
}
</script>
<style lang="scss">
@import "../../styles/settings.scss";
@import "../../assets/fonts/fontsheet.css";

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

.knowledge_bar_description{
    height: 1em;
    font-size: 0.9em;
    width: 20vw;
}

.knowledge_bar_description.show{
    opacity: 1;
}

.knowledge_bar_description.hide{
    opacity: 0;
}

@media screen and (max-width: 800px){
    .knowledge_set{
        width: 60vw;
        flex-wrap: wrap;   
    }
    
    .knowledge_set_left{
        margin-bottom: 0.5em;
    }

    .knowledge_set_left, .bar_inside, .knowledge_bar_description{
        width: 60vw;
    }
}

@media print {    
    .knowledge_set{
        width: 60vw;
        display: block;
        margin-left: 20vw;
    }

    .knowledge_set_left, .bar_inside, .knowledge_bar_description{
        width: 60vw;
    }

    .knowledge_set_left{
        margin-bottom: 0.5em;
    }

    .knowledge_bar {
        background-color: $light-action-color !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }

    .top_knowledge_bar {
        background-color: $action-color !important;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
    }
    .knowledge_bar_description.show, .knowledge_bar_description.hide{
        opacity: 1;
    }
}
</style>
