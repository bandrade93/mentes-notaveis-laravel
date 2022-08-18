<template>
    <div>
        <app-page-header
			icon="fa fa-cog"
			title="Cadastrar Estado"
			:breadcrumbs="[
				{ href: '/', title: 'Painel' },
				{ href: '/states', title: 'Estados' },
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
                                <app-input
									placeholder="UF"
									label="UF"
									name="uf"
									:minLength="2"
									:maxLength="2"
									:required="true"
								></app-input>
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
    import Link from '../forms/LinkComponent';

    export default {
		components: {
            'app-input': Input,
            'app-button': Button,
			'app-page-header': PageHeader,
			'app-link': Link
		},
        props: {
			backUrl: String,
		},
        methods: {
            async onSubmit() {
                let data = new FormData(this.$refs.form);

                let validate = this.validateForm(this.$refs.form);

                if (validate != '') {
					Flash('error', validate);
				} else {
					axios.post('/states', data)
						.then(res => {
							Swal.fire({
								title: 'Cadastrado com sucesso!',
								type: 'success'
							})
							.then(result => {
								window.location.href = '/states';
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