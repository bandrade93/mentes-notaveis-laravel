<template>
	<div>
        <app-page-header
            icon="fa fa-cog"
            title="Estados"
            :breadcrumbs="[
                { href: '/', title: 'Painel' }
            ]"
        ></app-page-header>

        <app-datatable
            entity="states"
            :allow-enable-multi="allows.enableMulti"
			:allow-disable-multi="allows.disableMulti"
			:allow-delete-multi="allows.deleteMulti"
            :options="{
                ajax: {
					url: '/states'
				},
				columns: this.columns
            }"
            :actions="{
				create: {
					allow: this.allows.create,
					url: '/states/create'
				},
				show: {
					allow: this.allows.show,
					url: '*',
					callback: onShow
				},
				edit: {
					allow: this.allows.edit,
					url: '/states/*/edit',
				},
				delete: {
					allow: this.allows.delete,
					url: '*'
				}
			}" 
        ></app-datatable>

        <app-state-show ref="stateShow"></app-state-show>
    </div>
</template>

<script>
    import PageHeader from '../PageHeaderComponent';
    import DataTable from '../DataTableComponent';
    import StateShow from './StateShowComponent';

    export default {
        components: {
            'app-page-header': PageHeader,
            'app-datatable': DataTable,
            'app-state-show': StateShow
        },
        props: {
            allows: Object,
            columns: Array,
            status: Array,
        },
        methods: {
			onShow(id) {
				this.$refs.stateShow.open(id);
			}
		}
    }
</script>