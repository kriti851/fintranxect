<div class="form-row">
    <div class="col-12 col-sm-12">
        <label>Title</label>
        <small class="text-danger" id="edit_title_error"></small>
        <input class="multisteps-form__input form-control" type="text" id="edit_title"  placeholder="Profile Title" value="<?php if(!empty($profile->title)){ echo $profile->title; } ?>" />
        <input type="hidden" id="profile_id" value="<?php echo $profile->profile_id; ?>">
    </div>
</div>
<div class="form-row">
    <div class="col-12 col-sm-12">
        <small class="text-danger" id="edit_permission_error"></small>
        <div class="table-responsive" style="overflow:hidden;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="25">Permission</th>
                        <th width="75">Sub Permission</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    
                    $permission_edit=[];
                    if($profile->permission){
                        $permission_edit=json_decode($profile->permission);
                    }
                    $sub_permission_edit=[];
                    if($profile->sub_permission){
                        $sub_permission_edit=json_decode($profile->sub_permission);
                    }
                    foreach($permission_list as $plist){ ?>
                    <tr>
                        
                        <td>
                            <div class="chiller_cb">
                                <input class="checkbox_lender" id="edit-permission-<?php echo $plist->id; ?>" name="edit_main_permission[]" value="<?php echo $plist->id; ?>" <?php if(!empty($permission_edit) && in_array($plist->id,$permission_edit)){ echo "checked"; } ?> type="checkbox" />
                                <label for="edit-permission-<?php echo $plist->id; ?>"></label>
                                <span><?php  echo $plist->title; ?></span>
                            </div>
                        </td>
                        <td>
                        <?php
                            if(!empty($plist->sub_permission)){ ?>
                            
                                <div class="row">
                                    <?php    foreach($plist->sub_permission as $splist){ ?>
                                    <div class="col-md-3">
                                        <div class="chiller_cb">
                                            <input class="checkbox_lender" id="edit-sub-p-<?php echo $splist->sub_id; ?>" name="edit_sub_permission[]" value="<?php echo $splist->sub_id; ?>" <?php if(!empty($sub_permission_edit) && in_array($splist->sub_id,$sub_permission_edit)){ echo "checked"; }elseif($splist->is_checked){ echo "checked"; } ?>  type="checkbox" />
                                            <label for="edit-sub-p-<?php echo $splist->sub_id; ?>"></label>
                                            <span><?php echo $splist->title; ?></span>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            
                        <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>