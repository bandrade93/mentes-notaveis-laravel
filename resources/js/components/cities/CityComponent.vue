<template>
	<div>
        <app-page-header
            icon="fa fa-cog"
            title="Cidades"
            :breadcrumbs="[
                { href: '/', title: 'Painel' }
            ]"
        ></app-page-header>

        <app-datatable
            entity="cities"
            :allow-enable-multi="allows.enableMulti"
			:allow-disable-multi="allows.disableMulti"
			:allow-delete-multi="allows.deleteMulti"
            :statusFilterIndex=5
            :options="{
                ajax: {
					url: '/cities'
				},
				columns: this.columns
            }"
            :actions="{
				create: {
					allow: this.allows.create,
					url: '/cities/create'
				},
				show: {
					allow: this.allows.show,
					url: '*',
					callback: onShow
				},
				edit: {
					allow: this.allows.edit,
					url: '/cities/*/edit',
				},
				delete: {
					allow: this.allows.delete,
					url: '*'
				}
			}"
            :filters="[{
                name: 'state_id',
                type: 'select',
                index: 6,
                label: 'Estado',
                options: this.states
            }]"
        ></app-datatable>

        <app-city-show ref="cityShow"></app-city-show>
    </div>
</template>

<script>
    import PageHeader from '../PageHeaderComponent';
    import DataTable from '../DataTableComponent';
    import CityShow from './CityShowComponent';

    export default {
        components: {
            'app-page-header': PageHeader,
            'app-datatable': DataTable,
            'app-city-show': CityShow
        },
        data() {
			return {
				states: []
			}
		},
        props: {
            allows: Object,
            columns: Array,
            status: Array,
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
			onShow(id) {
				this.$refs.cityShow.open(id);
			}
		}
    }
</script>