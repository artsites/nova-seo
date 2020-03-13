<template>
<div>
	<panel-item :field="dataTitle"></panel-item>
	<panel-item :field="dataKeywords"></panel-item>
	<panel-item :field="dataDescription"></panel-item>
    </div>
</template>

<script>
export default {
    props: ["resource", "resourceName", "resourceId", "field"],

    
    created(){
        console.log(this.field);
        
        
    },
    mounted(){
        // console.log(this);
        
    },
    computed:{
        dataTitle(){
            let object = {};
            Object.assign(object, this.field)
            object.value = object.value.title;
            object.name = 'Title';
            return object;
        },
        dataKeywords(){
            let object = {};
            Object.assign(object, this.field)
            object.value = object.value.keywords;
            object.name = 'Keywords';
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
