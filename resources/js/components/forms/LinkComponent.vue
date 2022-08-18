<template>
    <a
        :id="id"
        :class="`btn btn${outlineData}-${colorData} btn-circle ${btnTypeData} pt-0 btn-circle-title`"
        :href="url"
        :title="titleData"
        :tabindex="tabIndex"
		:role="role"
		:data-toggle="dataToggle"
		:data-trigger="dataTrigger"
		:data-content="dataContent"
		@click="onClick"
    >
        <i :class="`fa fa-${iconData}`"></i>
		<span class="d-none d-lg-inline-block">{{ titleData }}</span>
    </a>
</template>

<script>
    export default {
        data() {
            return {
                titleData: String,
				iconData: String,
				colorData: String,
				btnTypeData: String,
				outlineData: String,
            };
        },
        props: {
            id: String,
			type: String,
			url: { type: String, default: 'javascript:' },
			onClick: { type: Function, default: () => {} },
			tabIndex: String,
			role: String,
			dataToggle: String,
			dataTrigger: String,
			dataContent: String,
			title: String,
			icon: String,
			color: String,
			btnType: { type: String, default: 'btn-circle-sm btn-table' },
			outline: { type: String, default: '-outline' },
        },
        mounted() {
			this.iconData = this.getIcon();
			this.titleData = this.getTitle();
			this.colorData = this.getColor();

			if (this.type == 'create') {
				this.btnTypeData = 'btn-circle-lg btn-plus';
				this.outlineData = '';
			} else {
				this.btnTypeData = this.btnType;
				this.outlineData = this.outline;
			}
		},
        methods: {
			getIcon() {
				if (this.icon != undefined) {
					return this.icon;
				}

				switch (this.type) {
					case 'add':
					case 'create': return 'plus';
					case 'edit': return 'pencil';
					case 'delete': return 'trash';
					case 'enableMulti': return 'toggle-on';
					case 'disableMulti': return 'toggle-off';
					case 'deleteMulti': return 'trash';
					case 'info': return 'info';
					case 'back': return 'undo';
				}

				return 'primary';
			},
			getTitle() {
				if (this.title != undefined) {
					return this.title;
				}

				switch (this.type) {
					case 'create': return 'Adicionar Novo';
					case 'edit': return 'Editar';
					case 'delete': return 'Excluir';
					case 'enableMulti': return 'Ativar Selecionados';
					case 'disableMulti': return 'Desativar Selecionados';
					case 'deleteMulti': return 'Deletar Selecionados';
					case 'info': return 'Informações';
					case 'back': return 'Voltar';
				}

				return '';
			},
			getColor() {
				if (this.color != undefined) {
					return this.color;
				}

				switch (this.type) {
					case 'edit': return 'warning';
					case 'delete': return 'danger';
					case 'enableMulti': return 'success';
					case 'disableMulti': return 'secondary';
					case 'deleteMulti': return 'danger';
					case 'info': return 'info';
					case 'back': return 'secondary';
				}

				return 'primary';
			}
		}
    }
</script>