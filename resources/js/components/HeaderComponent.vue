<template>
    <header class="app-header">
        <a href="/" class="app-header__logo bg-orange p-0" :title="title"></a>
        <a class="app-sidebar__toggle"
			href="javascript:"
			data-toggle="sidebar"
			aria-label="Hide Sidebar"
			v-on:click="onToggleSideBar">  
        </a>
        <ul class="app-nav">
			<li class="app-search">
				<input class="app-search__input" type="search" placeholder="Busca">
				<button class="app-search__button">
					<i class="fa fa-search"></i>
				</button>
			</li>
			<li class="dropdown">
			</li>
		</ul>
    </header>
</template>

<script>
    export default {
        props: {
            title: String
        },
        methods: {
            onToggleSideBar: () => {
                if (cash('.sidenav-toggled').length) {
					localStorage.setItem('menuState', 'show');
				} else {
					localStorage.setItem('menuState', 'hide');
				}
            }
        }
    }
</script>