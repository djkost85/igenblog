            <div class="photoItem" onClick="Javascript:toSelectPhoto(<?php echo $var['im_id'];?>);">
              <div class="photo">
                <img src="<?php echo $var['im_image'];?>">
              </div>
              <div class="info">
              	<div class="head">
                  <div class="id">#<?php echo $var['im_id']+1024;?></div>

                  <div class="category" onClick="Javascript:modeListPhoto(<?php echo $var['ca_id'];?>);$('#categoryMode').val('<?php echo $var['ca_id'];?>');"><i class="fa fa-folder-open"></i> <?php echo $var['ca_title'];?></div>
                  <?php
                  if($var['im_status'] == 1){
                    ?><div class="status s" onClick="Javascript:statusPhoto(<?php echo $var['im_id'];?>,<?php echo $var['im_status'];?>);"><i class="fa fa-globe"></i> เผยแพร่</div><?php
                  }
                  else{
                    ?><div class="status d" onClick="Javascript:statusPhoto(<?php echo $var['im_id'];?>,<?php echo $var['im_status'];?>);"><i class="fa fa-file-text-o"></i> แบบร่าง</div><?php
                  }
                  ?>
                  
                  
                </div>
                <div class="text">
                	<?php echo $var['im_description'];?> <span id="loading-<?php echo $var['im_id'];?>"></span>
                </div>
              </div>
            </div>