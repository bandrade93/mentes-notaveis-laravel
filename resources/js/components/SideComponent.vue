<template>
	<aside class="app-sidebar">
		<div class="app-sidebar__user">
		</div>
		<app-menu></app-menu>
	</aside>
</template>

<script>
	import Menu from './MenuComponent';

	export default {
		components: {
			'app-menu': Menu
		},
		props: {
			// user: Object,
		}
	}
</script>