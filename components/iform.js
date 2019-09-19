Vue.component('iform', {
			template: `
<div :class="'gys-kl-'+lieobj.lg">
<div class="gys-fm">
<label class="gys-fmt" :for="lieobj.mz">{{lieobj.bt}}</label>
<input type="text" :value="lieobj.value" @input="input" :name="lieobj.mz" :type="lieobj.ty" :title="lieobj.ds" :placeholder="lieobj.ds" :maxlength="lieobj.mx">
</div>
</div>
</div>
`,
			props: {
				lieobj: {},
				id:0
			},
			methods: {
				input(event) {
					var value = event.target.value;
					this.$nextTick(() => {
							this.$emit('model', {
								'val': value,
								'id': this.id
							})});
					}
				},
			});
