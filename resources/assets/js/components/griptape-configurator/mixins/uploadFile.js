export default {
    props: {
        options: {
            type: Object,
            default: false
        },
        files: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            step_options: {
                state: this.options.state || false,
                file: this.options.file || null,
            }
        }
    },
    watch: {
        'step_options.state'(val){
            this.$emit('stateChange', val);
        },
        'step_options.file'(val){
            this.$emit('fileChange', val);
        }
    },
    methods: {
        uploadFile(event) {
            if(document.body.getAttribute('signed') == 0){
                swal({
                    title: "",
                    text: "You need to login to upload file",
                    type: "warning",
                    confirmButtonClass: "btn btn-secondary m-btn m-btn--wide"
                }).then((value) => {
                    window.location.href = "/login";
                });
                return;
            }

            let target = event.target;

            if (!Object.keys(target.dataset).length) {
                return false;
            }

            let formData = new FormData();
            let filename = target.getAttribute('filename');
            let id = target.getAttribute('id');

            formData.append('typeUpload', target.dataset.typeUpload);

            formData.append('file', target.files[0]);

            axios.post('/configurator-fileupload', formData)
                .then(response => response.data)
                .then(response => {
                    if(response != 'failed'){
                        target.setAttribute('fileName', response);
                        target.nextElementSibling.classList.remove("unchecked");
                        $('button', target.parentNode.parentNode.nextElementSibling).addClass("unchecked");
                        $('button', target.parentNode.parentNode.nextElementSibling).html(response);
                        
                        this.step_options.file = response;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}