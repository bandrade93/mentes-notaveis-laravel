<template>
	<ul class="app-menu">
        <li v-for="item in items" v-bind:class="{ treeview: (item instanceof Array) }">
            <a
				v-if="!(item instanceof Array)"
				:href="'/' + item.controller"
				class="app-menu__item"
			>
				<i v-bind:class="'app-menu__icon fa fa-' + item.icon"></i>
				<span class="app-menu__label">{{ item.title }}</span>
			</a>
        </li>
    </ul>
</template>

<script>
	export default {
		data: (e) => {
			return {
				items: []
			}
		},
		created() {
			axios.get('/menus')
				.then(res => {
					this.items = res.data;
				})
				.catch(err => {});
		},
		mounted() {
			cash("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
		},
		methods: {
			getAction(action) {
				return (action != 'index') ? action : '';
			},
			onTreeViewClick: (e) => {
				e.preventDefault();
				var treeviewMenu = cash('.app-menu');

				if (!cash(e.currentTarget).parent().hasClass('is-expanded')) {
					treeviewMenu.find("[data-toggle='treeview']")
						.parent()
						.removeClass('is-expanded');
				}

				cash(e.currentTarget).parent().toggleClass('is-expanded');
			}
		}
	}
</script>