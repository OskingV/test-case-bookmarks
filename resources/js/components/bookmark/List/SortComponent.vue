<template>
    <span>
        <font-awesome-icon :icon="['fas', 'sort-amount-up']" style="cursor: pointer" @click="$parent.getSortList(field, 'asc')"/>
        <font-awesome-icon :icon="['fas', 'sort-amount-down']" style="cursor: pointer" @click="$parent.getSortList(field, 'desc')" />
    </span>
</template>

<script>
export default {
    props: ['field', 'type']
}
</script>
