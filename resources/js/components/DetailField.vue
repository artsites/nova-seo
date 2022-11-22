<template>
<div>
	<panel-item :field="dataTitle"></panel-item>
	<panel-item :field="dataDescription"></panel-item>
    </div>
</template>

<script>
export default {
    props: ["resource", "resourceName", "resourceId", "field"],
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
