<template>
  <div>
    <button class="btn btn-success btn-xs" @click.prevent="imprimir" title="Imprimir Liquidación">
      <span class="btn-label">
        <i class="la la-print"></i>
      </span>      
    </button>
  </div>
</template>
<script>

export default {
  props: ['row', 'nested','xprops'],
  mounted () {
    $(this.$el).find('button[title]').tooltip()
  },
  methods: {
    imprimir(){
      this.xprops.eventbus.$emit('RELOAD2',this.row)
    }
  }
}
</script>
<style>
.-nested-comp-open-btn {
  color: #fff !important;
  background-color: #337ab7 !important;
}
</style>
