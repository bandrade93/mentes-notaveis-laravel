<template>
    <div>
        <app-page-header
			icon="fa fa-cog"
			title="Cadastrar Usuário"
			:breadcrumbs="[
				{ href: '/', title: 'Painel' },
				{ href: '/users', title: 'Usuários' },
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
									placeholder="Email"
									label="Email"
									name="email"
									:minLength="2"
									:maxLength="50"
									:required="true"
								></app-input>
                                <app-input
									type="date"
									placeholder="Data Nascimento"
									label="Data Nascimento"
									name="date"
									:required="true"
								></app-input>
                                <app-input
									placeholder="Telefone"
									label="Telefone"
									name="phone"
									v-mask="'(##) #####-####'"
									:minLength="2"
									:maxLength="50"
									:required="true"
								></app-input>
                                <app-input
									placeholder="Password"
									label="Password"
									name="password"
                                    type="password"
									:minLength="2"
									:maxLength="50"
									:required="true"
								></app-input>
                            </div>
                            <div class="row">
                                <app-input
									placeholder="Rua"
									label="Rua"
									name="street"
									:minLength="2"
									:maxLength="50"
									:required="true"
								></app-input>
                                <app-input
									placeholder="Nº"
									label="Nº"
									name="number"
                                    type="number"
									:required="true"
								></app-input>
                                <app-input
									placeholder="CEP"
									label="CEP"
									name="cep"
									v-mask="'#####-###'"
									:minLength="9"
									:maxLength="9"
									:required="true"
								></app-input>
                                <app-select
									title="Estado"
									label="Estado"
									name="state_id"
									:required="true"
									:options="states"
                                    :callback="onChangeState"
								></app-select>
                                <app-select
									title="Cidade"
									label="Cidade"
									name="city_id"
									:required="true"
									:options="cities"
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
    import Select from '../forms/SelectComponent';
    import Button from '../forms/ButtonComponent'
    import Link from '../forms/LinkComponent';

    export default {
		components: {
            'app-input': Input,
            'app-button': Button,
			'app-page-header': PageHeader,
			'app-link': Link,
            'app-select': Select,
		},
        data() {
			return {
				states: [],
                cities: [],
			}
		},
        props: {
			backUrl: String,
		},
        mounted() {
			this.loadStates();
		},
        methods: {
            onChangeState(state_id) {
				axios.get('/cities/getCitiesByState/' + state_id)
					.then(res => {
						this.cities = res.data;
					})
					.catch(err => {});
			},
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
					axios.post('/users', data)
						.then(res => {
							Swal.fire({
								title: 'Cadastrado com sucesso!',
								type: 'success'
							})
							.then(result => {
								window.location.href = '/users';
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