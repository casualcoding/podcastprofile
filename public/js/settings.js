Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

window.$podcasts = window.$podcasts.map(function(podcast) {

    podcast.comment = podcast.pivot.description;
    podcast.position = podcast.pivot.position;
    podcast.visible = podcast.pivot.visible;

    return podcast;
});

$(function() {

    var settings = new Vue({

        el: '#settings',

        ready: function() {
            this.sortable = UIkit.sortable(this.$els.list, { handleClass:'uk-sortable-handle' });
        },

        data: {
            user: window.$user,
            podcasts: window.$podcasts
        },

        methods: {
            save: function(e) {

                var url = $(e.target).attr('action');

                this.$http.post(url, {
                    name: this.user.name,
                    url: this.user.url,
                    avatar: this.user.avatar
                }).then(function () {

                    // // cleanup empty items - maybe fixed with future vue.js version
                    // sortables.children().each(function () {
                    //     if (!this.children.length) $(this).remove();
                    // });
                }).catch(function() {
                    alert('Saving failed')
                }).finally(function() {

                })

            },

            savePodcasts: function() {

                var ids = this.sortable.serialize().map(function(obj) {
                    return obj.id;
                });

                var positionForId = function(id) {
                    var pos = 0;
                    while (ids[pos] != id && pos<ids.length) {
                        pos++
                    }
                    return pos;
                };

                var data = this.podcasts.map(function(podcast) {
                    return {
                        id: podcast.id,
                        position: positionForId(podcast.id),
                        visible: podcast.visible, // FIXME
                        description: podcast.comment
                    }
                });

                this.$http.post(window.$routes.savePodcasts, {podcasts: data}).then(function() {
                    UIkit.notify("Saved", "success");
                }).catch(function() {
                    UIkit.notify("Oops, could not save.", "danger");
                })


                // data = [{id: 23, position: 2, visible: true, description: 'Hello'}]
            }
        }
    });

    var upload = new Vue({
        el: '#upload-opml',

        methods: {

            upload: function(e) {
                var url = e.target.getAttribute('action');
                var files = this.$els.xml.files;
                var data = new FormData();
                data.append('xml', files[0]);

                this.$http.post(url, data).then(function () {
                    UIkit.notify('Uploaded', 'success');
                }).catch(function (resp, b, c) {
                    UIkit.notify('Upload failed: '+resp.data.error, 'danger');
                });
            }

            // upload: function() {
            //     var url = this.$els.form.getAttribute('action');
            //
            //     var input = this.$els.file.files;
            //
            //     this.newInput = { name: '', image: ''};
            //
            //     input.image = this.$$.fileInput.files; // Get the input as the DOM and get the files, With the v-model you are getting the name of the file
            //     console.log(input);
            //     this.$http.post(url,input);
            // }
        }
    });

});
