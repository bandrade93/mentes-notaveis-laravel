<template>
    <div class="row">
		<div id="content" class="col-md-12">
			<form ref="multiForm">
				<div class="tile">
					<div class="dt-buttons">
						<app-link
							v-if="allowEnableMulti"
							type="enableMulti"
							:onClick="onEnableMulti"
						></app-link>
						<app-link
							v-if="allowDisableMulti"
							type="disableMulti"
							:onClick="onDisableMulti"
						></app-link>
						<app-link
							v-if="allowDeleteMulti"
							type="deleteMulti"
							:onClick="onDeleteMulti"
						></app-link>
					</div>
					<hr />
					<table class="table table-striped display responsive nowrap" id="table">
						<thead></thead>
						<tbody></tbody>
					</table>
				</div>
			</form>
		</div>
		
        <app-side-filter
			ref="filter"
			:onChangeCallback="onChangeSideFilter"
		></app-side-filter>

		<app-link
			v-if="this.actions.create && this.actions.create.allow"
			type="create"
			:url="this.actions.create.url"
		></app-link>
	</div>
</template>

<script>
    import SideFilter from './SideFilterComponent';
	import Link from './forms/LinkComponent';

    export default {
        components: {
			'app-side-filter': SideFilter,
			'app-link': Link
		},
		props: {
			entity: String,
			print: { type: Boolean, default: false },
			options: Object,
			actions: Object,
			filters: Array,
			allowEnableMulti: Boolean,
			allowDisableMulti: Boolean,
			allowDeleteMulti: Boolean,
			statusFilterIndex: { type: Number, default: 0 },
		},
        mounted() {
            this.addScripts([
                '/assets/js/plugins/jquery.dataTables.min.js',
				'/assets/js/plugins/dataTables.bootstrap.min.js',
				'/assets/js/plugins/dataTables.responsive.min.js',
				'/assets/js/plugins/dataTables.buttons.min.js',
				'/assets/js/plugins/buttons.print.min.js',
				'/assets/js/plugins/bs-breakpoints.min.js',
				'/assets/js/DataTables.js',
            ], this.callback);
        },
        methods: {
            callback() {
                this.options.configs = {
					lengthMenu: [10, 30, 50, 100],
					ordering: true,
					searching: true,
					processing: true,
					serverSide: true,
					deferRender: true,
					responsive: true,
					autoWidth: false,
					order: [1, 'asc']
				};

                this.options.language = {
					sEmptyTable: "Nenhum registro encontrado",
				    sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
				    sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
				    sInfoFiltered: "(Filtrados de _MAX_ registros)",
				    sInfoPostFix: "",
				    sInfoThousands: ".",
				    sLengthMenu: "_MENU_",
				    sLoadingRecords: "Carregando...",
				    sProcessing: "Processando...",
				    sZeroRecords: "Nenhum registro encontrado",
				    sSearch: "",
				    sSearchPlaceholder: "Pesquisar",
				    oPaginate: {
				        sNext: "Próximo",
				        sPrevious: "Anterior",
				        sFirst: "Primeiro",
				        sLast: "Último"
				    },
				    oAria: {
				        sSortAscending: ": Ordenar colunas de forma ascendente",
				        sSortDescending: ": Ordenar colunas de forma descendente"
				    }
				};

                if (Object.keys(this.actions).length) {
					this.options.actions = this.formatActions(this.actions);
					
					this.options.columns.push({
                        title: 'Ações',
                        orderable: false,
                        searchble: false,
                    });
				}
				
				window.datatables = new DataTables(this.options, this.print);
				window.datatables.onLoaded = this.setClickEvents;

				if (this.statusFilterIndex > 0) {
					this.loadStatusFilter();
				}

				this.loadFilters();
            },
			loadStatusFilter() {
				this.$refs.filter.add({
					name: 'active',
					type: 'select',
					index: this.statusFilterIndex,
					label: 'Status',
					options: [
						{ 'value': '0', 'label': 'Inativo' },
            			{ 'value': '1', 'label': 'Ativo' }
					]
				});
			},
			loadFilters() {
				for (let i = 0; i < this.filters.length; i++) {
					this.$refs.filter.add(this.filters[i]);
				}
			},
			onChangeSideFilter(data) {
				window.datatables.filter(data);
			},
            formatActions(a) {
                let actions = {};
				
				if (a.hasOwnProperty('show') && a.show.allow) {
					actions.show = this.getButton(
						'show',
						'eye',
						a.show.title ?? 'Visualizar',
						'javascript:',
						'*',
						'info',
					);
				}

				if (a.hasOwnProperty('edit') && a.edit.allow) {
					actions.edit = this.getButton(
						'edit',
						'pencil',
						'Editar',
						a.edit.url,
						null,
						'warning'
					);
				}

				if (a.hasOwnProperty('delete') && a.delete.allow) {
					actions.delete = this.getButton(
						'delete',
						'trash',
						'Deletar',
						'javascript:',
						'*',
						'danger',
						'onDelete'
					);
				}
                
				return actions;
            },
            getButton(type, icon, title, href, onclick = null, color = 'info', callback = null) {
                return `
                    <a
					    class="btn btn-outline-${color} btn-circle btn-circle-sm btn-table"
					    data-content="${title}"
					    href="${href}"
					    data-toggle="popover"
					    data-type="${type}"
					    ${(onclick) ? `data-id="${onclick}" ` : ''}
					    ${(callback) ? `data-function="${callback}" ` : ''}
					>
                        <i class="fa fa-${icon}"></i>
					</a>
                `;
            },
            onEnableMulti() {
				this.onConfirmMultiAction(
					'Ativar?',
					'Deseja realmente ativar selecionados?',
					`/${this.entity}/enableMulti`
				);
			},
			onDisableMulti() {
				this.onConfirmMultiAction(
					'Desativar?',
					'Deseja realmente desativar selecionados?',
					`/${this.entity}/disableMulti`
				);
			},
			onDeleteMulti() {
				this.onConfirmMultiAction(
					'Deletar?',
					'Deseja realmente excluir selecionados?',
					`/${this.entity}/deleteMulti`
				);
			},
            onConfirmMultiAction(title, text, url) {
				Swal.fire({
					type: 'warning',
			        title: title,
			        text: text,
			        showCancelButton: true,
			        confirmButtonText: 'Ok',
			        cancelButtonText: 'Cancelar',
				}).then((res) => {
					if (res.value) {
						if ($(this.$refs.multiForm).find('[type="checkbox"]:checked').length) {
							this.executeMultiAction(url);
						} else {
							Swal.fire({
								type: 'warning',
								title: 'Atenção!',
								text: 'Selecione pelo menos um registro!'
							});
						}
					}
				});
			},
            executeMultiAction(url) {
				let data = new FormData(this.$refs.multiForm);
				data.append('_method', 'PATCH');
				
				axios.post(url, data)
					.then(res => {
						window.datatables.table.ajax.reload();
						Flash('success', 'Atualizado com sucesso!');
					})
					.catch(err => {
						Flash('error', 'Não foi possível executar a ação, tente novamente!');
					});
			},
			setClickEvents() {
				$('[data-id]').off();
				$('[data-id]').on('click', this.onClick);
			},
			onClick(e) {
				let id = cash(e.currentTarget).data('id');
				let type = cash(e.currentTarget).data('type');
                
				switch (type) {
					case 'delete':
						this[cash(e.currentTarget).data('function')](id);
						break;
					default:
						this.actions[type].callback(id);
				}
			},
			onDelete(id) {
				Swal.fire({
			        type: 'warning',
			        title: 'Deletar?',
			        text: 'Deseja realmente excluir este cadastro?',
			        showCancelButton: true,
			        confirmButtonText: 'Deletar',
			        cancelButtonText: 'Cancelar',
			    }).then((response) => {
			        if (response.value) {
			            axios.delete(`/${this.entity}/${id}`)
							.then(res => {
								window.datatables.table.ajax.reload();
								Flash('success', 'Atualizado com sucesso!');
							})
							.catch(err => {
								Flash('error', 'Erro ao tentar deletar registro!');
							});
			        }
			    });
			}
        }
    }
</script>