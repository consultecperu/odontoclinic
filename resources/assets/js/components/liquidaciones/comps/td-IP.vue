<template>
  <span class="center badge" :class="{'badge-danger' : value == 0,'badge-primary' : value == 1 }">{{ value == 0 ? 'PENDIENTE' : 'PAGADO' }}</span>
</template>
<script>
export default {
  props: ['value']
}
</script>
