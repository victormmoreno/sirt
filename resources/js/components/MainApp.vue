<template>
    <div v-if="">

        <Header/>
        <div class="content">
          <router-view></router-view>
        </div>
    </div>
   
    
</template>

<script>

    import Header from './spa/Header.vue';
    export default {
        name: 'main-app',
        components: {Header}
    };
</script>
