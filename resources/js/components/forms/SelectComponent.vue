<template>
	<div :class="containerClass">
		<div class="form-group" :class="{ 'required' : required }">
			<label v-if="label" :for="name">
				{{ label }}
				<a
					v-if="help"
					:id="id"
					tabindex="0"
					class="btn btn-outline-info btn-circle btn-circle-xm mb-1"
					data-toggle="popover"
					data-trigger="focus"
					role="button"
					:data-content="help.text"
				>
					<i class="fa fa-question"></i>
				</a>
			</label>
			<select
				:id="id"
				:name="name"
				:class="className"
				:required="required"
				:title="title"
				v-model="select"
				@change="onChange"
			>
				<option v-if="empty && empty != 'false'" selected value="">{{ empty }}</option>
				<option v-if="!empty" value="">-</option>
				<option
					v-for="option in options"
					:value="option.value"
					:selected="value == option.value"
				>
					{{ option.label }}
				</option>
			</select>
			<div v-if="error" class="invalid-feedback">
				{{ error }}
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				select: '',
			};
		},
		props: {
			id: String,
			label: String,
			name: String,
			value: String | Number,
			required: Boolean,
			options: Array,
			title: String,
			className: { type: String, default: 'custom-select form-control' },
			containerClass: { type: String, default: 'col-12 col-xl-3 col-md-6' },
			empty: String,
			help: Object,
			error: String,
			callback: Function
		},
		mounted() {
			this.select = this.value ?? '';
		},
		methods: {
			onChange() {
				if (this.callback) {
					this.callback(this.select);
				}
			}
		}
	}
</script>