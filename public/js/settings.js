Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

$(function() {

    var settings = new Vue({
        el: '#settings',

        data: {
            'user': window.$user
        },

        methods: {
            save: function(e) {

                var url = $(e.target).attr('action');

                this.$http.post(url, {
                    name: this.user.name,
                    url: this.user.url,
                    avatar: this.user.avatar
                }).catch(function() {
                    alert('Saving failed')
                })

            }
        }
    });

});
