<template>
	<div>
        <app-page-header
            icon="fa fa-cog"
            title="Usuários"
            :breadcrumbs="[
                { href: '/', title: 'Painel' }
            ]"
        ></app-page-header>

        <app-datatable
            entity="users"
            :allow-enable-multi="allows.enableMulti"
			:allow-disable-multi="allows.disableMulti"
			:allow-delete-multi="allows.deleteMulti"
			:statusFilterIndex=7
            :options="{
                ajax: {
					url: '/users'
				},
				columns: this.columns
            }"
            :actions="{
				create: {
					allow: this.allows.create,
					url: '/users/create'
				},
				show: {
					allow: this.allows.show,
					url: '*',
					callback: onShow
				},
				edit: {
					allow: this.allows.edit,
					url: '/users/*/edit',
				},
				delete: {
					allow: this.allows.delete,
					url: '*'
				}
			}"
        ></app-datatable>

        <app-user-show ref="userShow"></app-user-show>
    </div>
</template>

<script>
    import PageHeader from '../PageHeaderComponent';
    import DataTable from '../DataTableComponent';
    import UserShow from './UserShowComponent';

    export default {
        components: {
            'app-page-header': PageHeader,
            'app-datatable': DataTable,
            'app-user-show': UserShow
        },
        props: {
            allows: Object,
            columns: Array,
            status: Array,
        },
        methods: {
			onShow(id) {
				this.$refs.userShow.open(id);
			}
		}
    }
</script>