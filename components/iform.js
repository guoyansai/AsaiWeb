Vue.component('iform', {
	model: {
		value: 'value',
		event: 'input'
	},
	props: ['value', 'eldb'],
	data() {
		return {
			modelVal: this.value,
			tempstr: ''
		}
	},
	created() {

this.tempstr =
`
<div :class="'gys-kl-'+eldb.lg">
<div class="gys-fm">
<label class="gys-fmt" :for="eldb.mz">{{eldb.bt}}</label>
<input type="text" :name="eldb.mz" :type="eldb.ty" :title="eldb.ds" :placeholder="eldb.ds" :maxlength="eldb.mx" @input="input" :value="modelVal">
</div>
</div>
</div>
`
	},

	template: this.tempstr,
	methods: {
		input() {
			console.log(this.modelVal)
			this.$emit('input', this.modelVal);
		}
	}
});
