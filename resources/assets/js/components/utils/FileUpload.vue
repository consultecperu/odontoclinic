<template>
<!--     <div class="row"> -->
        <div class="container-Photo">
            <div>
                <img class="img-Photo pl-0" :src="image" >
            </div>
            <div class="col-md-12 pl-0 pr-0 mt-5" v-if="!image">
                <label for="file-upload" class="custom-file-upload">
                    <i class="fa fa-cloud-upload"></i> Seleccionar
                </label>
                <input id="file-upload" type="file" @change="onFileChange"/>
            </div>
            <div class="col-md-12 pl-0 pr-0" v-if="image"> 
                <button type="button" class="btn btn-danger btn-block" @click.prevent="removeImage">Borrar</button>
            </div>
        </div>
<!--     </div> -->
</template>
<script>
export default{
    data(){
        return {
            image: ''
        }
    },
    props: ['fileImagen'],
    created: function() {
        this.$parent.$on('getClear', this.removeImage);
    },
    methods: {
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.image = null;
                return;
            }
            this.createImage(files[0]);
            //console.log('archivo -> ' + files[0].name); // nombre del archivo
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
                this.$emit('cargaImagen', vm.image); // enviamos la imagen al componente principal
            };
            reader.readAsDataURL(file);
        },
        upload(){    // Accion para subir las imagenes al servidor
            axios.post('/upload',{image: this.image}).then(response => {

            });
        },
        removeImage: function (e) {
            this.image = '';
            $('input[type=file]').val('');
        }
    }
}
</script>
<style scoped>
    .container-Photo {
        width: 128px;
        height: 150px;
    }

    .img-Photo {
        width: 128px;
        height: 128px;
        padding: 3px;
    }

    input[type="file"] {
        display: none;
    }
    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 8px 12px;
        cursor: pointer;
        /*color: blue;*/
        width: 100%;
    }    
</style>
