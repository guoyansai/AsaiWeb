Vue.component('iform', {
	template: `
<div :class="'gys-kl-'+lieobj.lg">
<div class="gys-fm">
<label class="gys-fmt" :for="lieobj.mz">{{lieobj.bt}}</label>
<input type="text" :name="lieobj.mz" :type="lieobj.ty" :title="lieobj.ds" :placeholder="lieobj.ds" :maxlength="lieobj.mx" @input="input" :value="modelVal">
</div>
</div>
</div>
`,
model:{value:'value',event:'input'},
	props: ['value','lieobj'],
	data(){
		return{
			modelVal:this.value
		}
	},
	methods:{
		input(){
			console.log(this.modelVal)
			this.$emit('input',this.modelVal);
		}
	}
});
