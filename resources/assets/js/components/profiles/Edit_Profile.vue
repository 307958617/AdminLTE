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
                                <label class="pull-left" for="avatar">头像:</label>
                                <input type="file" id="avatar">
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
        props:['user','position','about'],
        methods: {
            updateProfile() {
                axios.patch('/profile/s_'+ this.user +'/update',{position:$('#position').val(),about:$('#about').val(),avatar:$('#avatar').val()}).then(response => {
                    $('#'+this.user).modal('hide');
                    $('h5.widget-user-desc').html(response.data.position);
                    $('#box-body-about').html(response.data.about);
                })
            }
        }
    }
</script>
