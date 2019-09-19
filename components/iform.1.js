Vue.component('iform', {
	template: `
<div :class="'gys-kl-'+lieobj.lg">
<div class="gys-fm">
<label class="gys-fmt" :for="lieobj.mz">{{lieobj.bt}}</label>
<input type="text" :value="modelval" @input="input" :name="lieobj.mz" :type="lieobj.ty" :title="lieobj.ds" :placeholder="lieobj.ds" :maxlength="lieobj.mx">
</div>
</div>
</div>
`,

	model: {
		prop: 'value',
		event: 'modelx'
	},
	props: {
		value: '',
		lieobj: {}
	},
	computed: {
		modelval: function() {
			return this.value
		}
	},
	methods: {
		input(event) {
			var value = event.target.value;
			this.$emit('modelx', value);
		}
	},
});
