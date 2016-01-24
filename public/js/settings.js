Vue.use(VueResource);

$(function() {

    var settings = new Vue({
        el: '#settings',

        data: {
            'user': window.$user
        },

        methods: {
            save: function() {
                alert('Not saving yet...');
            }
        }
    });

});
