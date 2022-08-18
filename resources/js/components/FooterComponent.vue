<template>
	<footer class="footer mt-auto py-3">
		<div class="container-fluid align-middle">
			<div class="pull-right text-muted text-right">
				<p>v.{{ appVersion }} - Mentes Notáveis © 2012/{{ currentYear }}</p>
			</div>
		</div>
	</footer>
</template>

<script>
	export default {
		props: {
			appVersion: String,
			currentYear: String,
		}
	}
</script>