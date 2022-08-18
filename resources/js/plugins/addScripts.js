export default {
    install(Vue, options) {
        Vue.prototype.addScripts = (urls, callback) => {
            function addScript() {
                if (urls.length) {
                    let script = document.createElement('script');
                    script.src = urls[0];
                    document.head.appendChild(script);
                    script.onload = () => {
                        addScript();
                    }
                    urls.splice(0, 1);
                } else {
                    if (callback) {
                        callback();
                    }
                }
            }

            addScript();
        };
    }
}