<template>
	<div ref="modal" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						<i class="fa fa-cog"></i>
						{{ title }}
					</h5>
					<button
						type="button"
						class="close"
						data-dismiss="modal"
						aria-label="Close"
						@click="onClose"
					>
			         	<span aria-hidden="true">&times;</span>
			        </button>
				</div>
				<div class="modal-body">
					<div class="row content">
						<div v-if="loading" class="col-12 text-center">
							<img src="/assets/img/loading.svg">
						</div>
						<div v-if="!loading" class="col-12">
							<div class="row">
								<div class="col-12 col-xl-3 col-md-6">
									<p><strong>Nome</strong></p>
									<p>{{ data.state.name }}</p>
								</div>
								<div class="col-12 col-xl-3 col-md-6">
									<p><strong>UF</strong></p>
									<p>{{ data.state.uf }}</p>
								</div>
								<div class="col-12 col-xl-3 col-md-6">
									<p><strong>Status</strong></p>
									<p>{{ data.state.active_text }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				modal: HTMLElement,
				title: '',
				loading: true,
				data: {}
			}
		},
		props: {
			defaultTitle: { type: String, default: 'Estado' }
		},
		mounted() {
			this.title = this.defaultTitle;
		},
		methods: {
			open(id) {
				this.loading = true;
				this.modal = $(this.$refs.modal);
				this.title = 'Carregando...';
				this.modal.modal('show');

				axios.get(`/states/${id}`)
					.then(res => {
						this.loading = false;
						this.data = res.data;
						this.title = `${this.defaultTitle}: ${this.data.state.name}`;
					})
					.catch(err => {});
			},
			onClose() {
				this.modal.modal('hide');
			}
		}
	}
</script>