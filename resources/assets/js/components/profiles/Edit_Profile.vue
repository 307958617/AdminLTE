<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#'+this.user">
            Edit Your Profile
        </button>
        <!-- Modal -->
        <div class="modal fade" :id="this.user" tabindex="-1" role="dialog" :aria-labelledby="this.user+'Label'">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" :id="this.user+'Label'">Edit {{ this.user }}'s profile</h4>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateProfile" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="pull-left" for="position">职位：</label>
                                <input type="text" class="form-control" id="position" placeholder="请输入职位"  :value="this.position">
                            </div>
                            <div class="form-group">
                                <label class="pull-left" for="about">简介：</label>
                                <textarea type="text" class="form-control" id="about" placeholder="请输入自我介绍...">{{ this.about }}</textarea>
                            </div>
                            <div class="form-group">
                                <div id="croppie" v-show="modalVisable"></div>
                                <div id="upload-wrapper">
                                    <div class="btn btn-primary btn-block" v-show="modalVisable == false" @click="modalVisable = true">
                                        <i class="fa fa-camera"></i> Upload Image
                                    </div>

                                    <div class="Model" v-if="modalVisable">
                                        <div class="input-file">
                                            <input type="file" id="upload-image" style="opacity: 0;position: fixed;margin-left: 35%" @change="setFileUploader"><h4 id="fileName">点击这里选择上传文件</h4>
                                        </div>

                                        <div class="btn btn-primary btn-sm" @click="upLoadFile">
                                            <i class="fa fa-upload"></i> Upload
                                        </div>
                                        <div class="btn btn-danger btn-sm" @click="modalVisable = false">
                                            <i class="fa fa-times"></i> Cancel
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">放弃</button>
                                <button type="submit" class="btn btn-primary">确认更改</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['user','position','about','imgUrl'],
        data() {
            return {
                modalVisable: false,
                croppie: null,
                image: null
            }
        },
        mounted() {
            this.$on('imageUploaded',function (imageData) {
                this.image = imageData;
                this.croppie.destroy();
                this.setUpCroppie(imageData);
            });
            this.image = this.imgUrl;//传递进来图片当前的url地址
            this.setUpCroppie();
        },
        methods: {
            updateProfile() {
                axios.post('/profile/s_'+ this.user +'/update',{position:$('#position').val(),about:$('#about').val(),avatar:$('#avatar')}).then(response => {
                    $('#'+this.user).modal('hide');
                    $('h5.widget-user-desc').html(response.data.position);
                    $('#box-body-about').html(response.data.about);
                })
            },
            setUpCroppie() {
                let el = document.getElementById('croppie');
                this.croppie = new Croppie(el, {
                    viewport: { width: 250, height: 250, type: 'circle' },
                    boundary: { width: 300, height: 300 },
                    showZoomer: true,
                    enableOrientation: true
                });
                this.croppie.bind({
                    url: this.image
                })
            },
            setFileUploader(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files){
                    return
                }
                this.createImage(files[0]);
                $('#fileName').html(files[0].name);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                    vm.$emit('imageUploaded',e.target.result);
                };

                reader.readAsDataURL(file)
            },
            upLoadFile() {
                this.croppie.result({
                    type: 'canvas',
                    size: 'viewport'
                }).then(response => {
                    this.image = response;
                    axios.post('/profile/s_'+ this.user +'/update',{img: this.image}).then(response => {
                        this.modalVisable = false
                    })
                })
            }
        }
    }
</script>
