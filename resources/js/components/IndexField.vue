<template>
    <span class="inline-block rounded-full w-2 h-2 bg-success">{{ fieldValue }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
