<template>
	<div :class="containerClass">
		<div :class="subClass">
			<label v-if="label" :for="name">{{ label }}</label>
			<div class="toggle lg">
				<input type="hidden" :name="name" value="0">
				<label>
					<input
						type="checkbox"
						:name="name"
						value="1"
						:checked="value == 1"
						v-model="input"
						@change="onChange"
					>
					<span class="button-indecator"></span>
				</label>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				input: this.value ?? 0
			};
		},
		props: {
			label: String,
			name: String,
			value: Number,
			containerClass: { type: String, default: 'col-12 col-xl-3 col-md-6' },
			subClass: { type: String, default: 'col-md-1' },
			label: String,
			callback: Function
		},
		methods: {
			onChange() {
				if (this.callback) {
					this.callback(this.input);
				}
			}
		}
	}
</script>