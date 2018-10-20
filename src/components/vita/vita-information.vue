<template>
    <div class="item_information"> 
        <div v-for="i in item" v-bind:key="i.id" class="information_set">
            <div class="information_set_left">{{i.name}}</div>
            <div class="information_set_right" v-html="i.value"></div>
        </div>
    </div>
</template>

<script>
export default {
  name: 'vita-information',
  props: ['item'],
  data () {
    return {
    }
  }
}
</script>

<style lang="scss">
    .information_set{
        display: flex;
        margin: 0.5em 0em;
    }

    .information_set_left{
        font-weight: bold;
        width: 20vw;
    }

    .information_set_right{
        word-break: break-word;
    }

    .item_information {
        width: 70vw;
        margin: 2em 0em;
    }
    @media screen and (max-width: 800px){
        .information_set{
            width: 60vw;
            flex-wrap: wrap;   
        }

        .information_set_left, .information_set_right{
            width: 60vw;
        }
    }

</style>