Vue.component('mycomponent', {
  template: `<div>
  <input type="text" :value="currentValue" @input="handleInput"/>
  </div>`,
  computed:{
    currentValue:function () {
      return this.value
    }
  },
  props: ['value'],
  methods: {
    handleInput(event) {
      var value = event.target.value;
      this.$emit('input', value);
    }
  }
});