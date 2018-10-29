<template>
    <div :id="itemid" class="table_align vita_item">
        <vita-koala v-if="singlevita.animatable == 1" :idsuffix="itemid"></vita-koala>
        <h2 v-if="singlevita.animatable == 1" @click="startKoala(itemid)">{{singlevita.text}}</h2>
        <h2 v-else @click="startKoala(itemid)">{{singlevita.text}}</h2>
        <vita-table v-if="typeof singlevita.values !== 'undefined' && singlevita.values.length > 0" :item="singlevita.values"></vita-table>
        <vita-knowledge v-if="typeof singlevita.skills !== 'undefined' && Object.keys(singlevita.skills).length > 0"  v-for="skill in singlevita.skills" :key="skill.id" :skills="skill"></vita-knowledge>
    </div>
</template>

<script>
import VitaInformation from './vita-information.vue';
import AnimatableKoala from './vita-koala.vue';
import VitaKnowledge from './vita-knowledge.vue'

export default {
  name: 'vita',
  components: {
      'vita-table': VitaInformation,
      'vita-knowledge': VitaKnowledge,
      'vita-koala': AnimatableKoala
  },
  props: ['singlevita','itemid'],
  data () {
    return {
    }
  },
  methods: {
      startKoala: function(itemid){
        this.$bus.$emit('koalaAnimation',itemid);
      }
  }
}
</script>

<style lang="scss">
@import "../../styles/settings.scss";

.table_align h2, .table_picture h2 {
    text-align: center;
    background-color: $heading-background-color;
    font-size: 1.4em;
    border-radius: 0.25em;
    box-shadow: 0em 0.5em 0.7em $shadow-color;
    width: 70vw;
    padding: 1em 0em;
}

.table_align h3 {
    background-color: $heading-background-color-secondary;
    font-size: 1.2em;
    text-align: center;
    border-radius: 0.25em;
    width: 60vw;
    padding: 0.75em 0em;
}

.vita_item {
    background-color: $secondary-background-color;
    border-radius: 1.25em;
    border-style: solid;
    border-color: $secondary-background-color;
    box-shadow: 0em 0.5em 0.7em $shadow-color;
    margin: 2.5em 0em;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: center;
    position: relative;
}

@media print {
    .table_align h2, .table_align h3 {
        page-break-inside: avoid;
        page-break-after: avoid;
    }

    .table_align h2{
        margin-left: 15vw;
    }

    .table_align h3{
        margin-left: 20vw;
    }

    .vita_item{
        display: block;
        margin-top: 1em;
        margin-bottom: 0em;
    }
}

@media screen and (max-width: 1110px){
    .table_align h3{
        min-width: fit-content;
    }
}
</style>
