<template>
	<button
		:id="id"
		:title="title"
		:class="'btn btn-circle btn-outline-' + color + ' ' + className + ' pt-0 btn-circle-title'"
		:disabled="disabled"
		type="button"
		@click="callback"
	>
		<i :class="'fa fa-' + icon"></i>
		<span class="d-none d-lg-inline-block">{{ title }}</span>
	</button>
</template>

<script>
	export default {
		data() {
			return {
				title: 'Cadastrar',
				icon: 'floppy-o'
			}
		},
		props: {
			id: { type: String, default: 'btSave' },
			color: { type: String, default: 'orange' },
			type: String,
			className: { type: String, default: 'btn-circle-sm btn-table' },
			disabled: Boolean,
			callback: Function
		},
		mounted() {
			if (this.type == 'update') {
				this.title = 'Salvar Alterações';
			}
		}
	}
</script>