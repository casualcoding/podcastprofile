Vue.use(VueResource);

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

window.$podcasts = window.$podcasts.map(function(podcast) {

    podcast.comment = podcast.pivot.description;
    podcast.position = podcast.pivot.position;
    podcast.visible = podcast.pivot.visible;

    return podcast;
});

var uploadform = new Vue({

    el: '#upload-opml',

    data: {
        uploading: false,
        uploaded: false,
        adding: false,
        feed_url: ''
    },

    methods: {

        addsingle: function(e) {
            var url = e.target.getAttribute('action');
            var data = {
                feed_url: this.feed_url,
            };

            this.adding = true;
            this.$http.post(url, data).then(function () {
                this.adding = false;
                UIkit.notify('Podcast added.', 'success');
            }).catch(function (resp, b, c) {
                this.adding = false;
                UIkit.notify('Error: '+resp.data.error, 'danger');
            });
        },

        performupload: function(e) {

            var url = e.target.getAttribute('action');
            var files = this.$els.xml.files;
            var data = new FormData();
            data.append('xml', files[0]);

            this.uploading = true;

            this.$http.post(url, data).then(function () {

                UIkit.notify('Uploaded', 'success');
                this.uploaded = true;
                this.uploading = false;

            }).catch(function (resp, b, c) {
                this.uploading = false;
                UIkit.notify('Upload failed: '+resp.data.error, 'danger');
            });
        }
    }
});

var settings = new Vue({

    el: '#settings',

    ready: function() {
        if(window.$podcasts.length > 0) {
            this.sortable = UIkit.sortable(this.$els.list, { handleClass:'uk-sortable-handle' });
        }
    },

    data: {
        editing: false,
        user: window.$user,
        podcasts: window.$podcasts
    },

    computed: {
        hiddenPodcasts: function() {
            return this.podcasts.filter(function(el) {
                return !el.visible;
            });
        },

        visiblePodcasts: function() {
            return this.podcasts.filter(function(el) {
                return el.visible;
            });
        }
    },

    methods: {
        save: function(e) {

            var url = $(e.target).attr('action');

            this.$http.post(url, {
                name: this.user.name,
                url: this.user.url,
                avatar: this.user.avatar
            }).then(function () {
                UIkit.notify("Saved.", "success");
                this.editing = false;
            }).catch(function() {
                UIkit.notify("Saving failed.", "danger");
                this.editing = false;
            });

        },

        savePodcasts: function() {

            var ids = this.sortable.serialize().map(function(obj) {
                return obj.id;
            });

            var positionForId = function(id) {
                var pos = 0;
                while (ids[pos] != id && pos<ids.length) {
                    pos++;
                }
                return pos;
            };

            var data = this.podcasts.map(function(podcast) {
                return {
                    id: podcast.id,
                    position: positionForId(podcast.id),
                    visible: podcast.visible, // FIXME
                    description: podcast.comment
                };
            });

            this.$http.post(window.$routes.savePodcasts, {podcasts: data})
                .then(function() {
                    UIkit.notify("Saved", "success");
                }).catch(function() {
                    UIkit.notify("Oops, could not save.", "danger");
                });
        },

        toggle: function(podcast) {
            podcast.visible = !podcast.visible;
        }
    }
});
