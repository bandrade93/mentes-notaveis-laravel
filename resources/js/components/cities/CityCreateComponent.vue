<template>
    <div>
        <app-page-header
			icon="fa fa-cog"
			title="Cadastrar Cidade"
			:breadcrumbs="[
				{ href: '/', title: 'Painel' },
				{ href: '/cities', title: 'Cidades' },
			]"
		></app-page-header>
        <div class="row">
			<div class="col-12">
				<div class="tile">
					<div class="tite-body">
						<form ref="form">
							<div class="row">
                                <app-input
									placeholder="Nome"
									label="Nome"
									name="name"
									:minLength="2"
									:maxLength="50"
									:required="true"
								></app-input>
                                <app-select
									title="Estado"
									label="Estado"
									name="state_id"
									:required="true"
									:options="states"
								></app-select>  
                            </div>
                            <hr />
                            <div class="row">
								<div class="col-12">
									<app-button
										type="save"
										:callback="onSubmit"
									></app-button>
									<app-link
										type="back"
										:url="backUrl"
									></app-link>
								</div>
							</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import PageHeader from '../PageHeaderComponent';
    import Input from '../forms/InputComponent';
    import Button from '../forms/ButtonComponent'
    import Select from '../forms/SelectComponent'
    import Link from '../forms/LinkComponent';

    export default {
		components: {
            'app-input': Input,
            'app-select': Select,
            'app-button': Button,
			'app-page-header': PageHeader,
			'app-link': Link
		},
        data() {
			return {
				states: []
			}
		},
        props: {
			backUrl: String,
		},
        mounted() {
			this.loadStates();
		},
        methods: {
            loadStates() {
				axios.get('/states/getStates')
					.then(res => {
						this.states = res.data;
					})
					.catch(err => {});
			},
            async onSubmit() {
                let data = new FormData(this.$refs.form);

                let validate = this.validateForm(this.$refs.form);

                if (validate != '') {
					Flash('error', validate);
				} else {
					axios.post('/cities', data)
						.then(res => {
							Swal.fire({
								title: 'Cadastrado com sucesso!',
								type: 'success'
							})
							.then(result => {
								window.location.href = '/cities';
							});
						})
						.catch(err => {
							Flash('error', 'Erro ao tentar salvar registro!');
						});
				}
            },
            validate(form) {
				cash(form).find('input,select').removeClass('is-invalid');
				cash(form).find('input,select').removeClass('is-valid');

				let result = this.validateForm(form.elements);

				return result;
			}
        }
    }

</script>