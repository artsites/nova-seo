<template>
    <PanelItem :index="index" :field="dataTitle"></PanelItem>
    <PanelItem :index="index" :field="dataDescription"></PanelItem>
</template>

<script>
export default {
    props: ['index', "resource", "resourceName", "resourceId", "field"],
    created(){
        //
    },
    mounted(){
        //
    },
    computed:{
        dataTitle(){
            let object = {};
            Object.assign(object, this.field)
            object.value = object.value.title;
            object.name = 'Title';
            return object;
        },
        dataDescription(){
            let object = {};
            Object.assign(object, this.field)
            object.value = object.value.description;
            object.name = 'Description';
            return object;
        },
    }
};
</script>
