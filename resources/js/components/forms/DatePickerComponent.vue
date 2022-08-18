<template>
	<div
		:id="containerId"
		:class="containerClass"
	>
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
        
        <input 
          :type="type"
          :name="name"
          :class="classInput"
          :pattern="pattern"
          :title="title"
          :required="required"
          :placeholder="placeholder"
          :value="value"
          v-model="time1"
          @change="onChange">
        <div v-if="error" class="invalid-feedback">
            {{ error }}
        </div>
        </div>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    data() {
      return {
        time1: null,
      };
    },
    props: {
			id: String,
			placeholder: String,
			type: { type: String, default: 'date' },
			className: { type: String, default: 'form-control' },
      classInput: {type: String, default: 'mx-input'},
			label: String,
			name: String,
			value: String,
			pattern: String,
			minLength: Number,
			maxLength: Number,
			title: String,
			required: Boolean,
			containerId: String,
			containerClass: { type: String, default: 'col-12 col-xl-3 col-md-6' },
			help: Object,
			error: String,
			callback: Function
		},
		mounted() {
			this.input = this.value || '';
		},
		methods: {
			onChange(e) {
				if (this.callback) {
					this.callback(this.input, e);
				}
			}
		}
  };
</script>