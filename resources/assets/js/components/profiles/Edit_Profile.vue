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
                                <div id="croppie"></div>
                                <div class="btn btn-block btn-success">是否上传头像</div>
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
                croppie: null,
                image: null
            }
        },
        mounted() {
            this.image = this.imgUrl;//传递进来图片当前的url地址
            this.setUpCroppie();
        },
        methods: {
            updateProfile() {
                axios.patch('/profile/s_'+ this.user +'/update',{position:$('#position').val(),about:$('#about').val(),avatar:$('#avatar')}).then(response => {
                    $('#'+this.user).modal('hide');
                    $('h5.widget-user-desc').html(response.data.position);
                    $('#box-body-about').html(response.data.about);
                })
            },
            setUpCroppie() {
                let el = document.getElementById('croppie');
                this.croppie = new Croppie(el, {
                    viewport: { width: 200, height: 200 },
                    boundary: { width: 300, height: 300 },
                    showZoomer: true,
                    enableOrientation: true
                });
                this.croppie.bind({
                    url: this.image
                })
            }
        }
    }
</script>
