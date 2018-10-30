<template>
    <div class="vita_knowledge">
        <h3>{{skills.name}}</h3>
        <vita-knowledge-set v-for="i in skills.values" :key="i.id" :set="i"></vita-knowledge-set>
    </div>
</template>

<script>
import VitaKnowledgeSet from './vita-knowledge-set.vue';
export default {
  name: 'knowledge',
  props: ['skills'],
    components: {
      'vita-knowledge-set': VitaKnowledgeSet
    },
  data () {
    return {
    }
  }
}
</script>

<style lang="scss">
.vita_knowledge{
    display: flex;
    justify-content: center;
    flex-direction: column;
    margin: 1em 0em;
}

@media print {
    .vita_knowledge{
        page-break-inside: avoid;
        display: block;
    }
}

</style>