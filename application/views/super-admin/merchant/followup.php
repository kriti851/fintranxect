<?php foreach($follow_up as $up){ ?>
    <div class="direct-chat-msg right">
        <div class="direct-chat-info clearfix"> 
        <span class="direct-chat-name pull-right">
            You
        </span> 
        <span class="direct-chat-timestamp pull-right"><?php echo  date('d M Y h:i A',strtotime($up->created_at)); ?></span> </div> 
        <div class="direct-chat-text"><?php echo $up->comments; ?></div>
        <span><?php echo date('Y-m-d h:i A',strtotime($up->follow_up)) ?></span>
        <span class="float-right" style="margin-right:14px;"> 
            <label class="switch">
            <input type="checkbox" id="isresolved<?php echo $up->remark_id; ?>" onclick="IsRemarked(`<?php echo $up->remark_id; ?>`)"; value="" <?php if($up->resolved=='NO' || $up->resolved==null){ echo '' ; }else{ echo 'checked'; } ?>>
            <span class="slider round"></span>
            </label>
        </span>
    </div>
<?php } ?>