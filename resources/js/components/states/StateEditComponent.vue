<template>
	<div>
		<app-page-header
			icon="fa fa-cog"
			:title="'Editar Estado: ' + state.id"
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
                                    :value="state.name"
                                ></app-input>
                                <app-input
									placeholder="UF"
									label="UF"
									name="uf"
									:minLength="2"
									:maxLength="2"
									:required="true"
									:value="state.uf"
								></app-input>
								<app-toggle
									label="Status"
									name="active"
									:value="state.active"
								></app-toggle>
                            </div>
                            <hr />
							<div class="row">
								<div class="col-12">
									<app-button
										type="update"
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
	import Toggle from '../forms/ToggleComponent';
	import Button from '../forms/ButtonComponent';
	import Link from '../forms/LinkComponent';

    export default {
        components: {
            'app-page-header': PageHeader,
            'app-input': Input,
            'app-toggle': Toggle,
            'app-button': Button,
            'app-link': Link
        },
        props: {
			backUrl: String,
			state: Object,
		},
        methods: {
            onSubmit() {
				let data = new FormData(this.$refs.form);
				data.append('_method', 'PATCH');

                let validate = this.validateForm(this.$refs.form);

                if (validate != '') {
                    Flash('error', validate);
                } else {
                    axios.post(`/states/${this.state.id}`, data)
                        .then(res => {
                            Swal.fire({
                                title: 'Atualizado com sucesso!',
                                type: 'success'
                            })
                            .then(result => {
                                window.location.href = '/states';
                            })
                            .catch(err => {
                                Flash('error', 'Erro ao tentar atualizar registro!');
                            })
                        })
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