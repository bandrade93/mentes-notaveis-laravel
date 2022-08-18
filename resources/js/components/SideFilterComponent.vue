<template>
    <aside class="app-filter-sidebar">
        <h1 class="h5 font-weight-normal ml-2">
			<a
				href="javascript:"
				class="btn btn-outline-secondary btn-sm btn-circle btn-circle-sm btn-table"
				title="Fechar Filtro"
				data-toggle="filter-sidebar"
			>
				<i class="fa fa-arrow-right"></i>
			</a>
			<i class="fa fa-filter ml-5"></i> Filtro
		</h1>
        <hr class="mb-2" />
        <div class="row m-0 filter">
            <div
				v-for="filter in filters"
				class="col-12"
				:class="{ 'input-daterange' : (filter.type === 'range') }"
			>
				<div v-if="filter.type === 'select'" class="form-group">
					<select
						class="selectpicker form-control form-control-sm"
						:index="filter.index"
						:name="filter.name"
						v-model="filter.value"
						@change="onChange"
					>
						<option v-if="filter.label" value="" selected>
							{{ filter.label }}
						</option>
						<option
							v-for="option in filter.options"
							:value="option.value"
							:selected="(filter.value == option.value)"
						>
							{{ option.label }}
						</option>
					</select>
				</div>
            </div>
        </div>
    </aside>
</template>

<script>
    export default {
        data() {
			return {
				filters: []
			};
		},
		props: {
			onChangeCallback: Function
		},
		mounted() {
			this.addScripts([
				'/assets/js/plugins/bootstrap-slider.js',
			], this.callback);
		},
        methods: {
            add(data) {
				data.value = data.hasOwnProperty('value') ? data.value : '';
				this.filters.push(data);
			},
			callback() {
				$('.filter')
					.find('[id*="Slider"]')
					.each((i, o) => {
						$(o).slider({});
					});

				$('.input-daterange')
					.datepicker({
			            format: "dd/mm/yyyy",
			            language: "pt-BR",
			            todayHighlight: true,
	                    clearBtn: true,
			            autoclose: true
			        });
				
				$('[data-toggle="filter-sidebar"]')
					.click((e) => {
						e.preventDefault();
						$('.app').toggleClass('sidefilter-toggled');
					});
			},
			onChange() {
				let data = [];

				for (let filter of this.filters) {
					data.push({ name: filter.name, value: filter.value });
				}

				this.onChangeCallback(data);
			}
        }
    }
</script>