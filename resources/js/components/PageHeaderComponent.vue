<template>
	<div class="app-title">
		<div>
			<h1>
				<i :class="icon"></i>
				{{ title }}
			</h1>
            <p v-if="subtitle != ''">{{ subtitle }}</p>
		</div>
		<ul class="app-breadcrumb breadcrumb my-0">
	    	<li class="breadcrumb-item">
	    		<i class="fa fa-home fa-lg"></i>
	    	</li>
	    	<li class="breadcrumb-item" v-for="breadcrumb in breadcrumbs">
	    		<a v-if="breadcrumb.href" :href="breadcrumb.href">{{ breadcrumb.title }}</a>
	    		<span v-if="!breadcrumb.href">{{ breadcrumb.title }}</span>
	    	</li>
	    </ul>
	</div>
</template>

<script>
    export default {
        props: {
            icon: {
                type: String,
                default: 'fa fa-file-o'
            },
            title: {
                type: String, 
                default: 'page title'
            },
            subtitle: {
				type: String,
				default: ''
			},
			breadcrumbs: {
				type: Array,
				default: []
			}
        }
    }
</script>