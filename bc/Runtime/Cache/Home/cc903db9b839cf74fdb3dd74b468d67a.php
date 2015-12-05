<?php if (!defined('THINK_PATH')) exit();?>
<?php if(is_array($imgs)): foreach($imgs as $key=>$t): ?><div class="col-sm-6 col-md-3">

              <div class="thumbnail thumbnail-warning" >
                <img data-src="<?php echo ($t["thumb_img"]); ?>" src="<?php echo ($t["viewimg"]); ?>" alt="image not found">
                <div class="caption">
                  <h5><?php echo ((isset($t["name"]) && ($t["name"] !== ""))?($t["name"]):'name not found'); ?></h5>
                  <p><?php echo ($t["company"]); echo ($t["brand"]); ?></p>
                  <p><a role="button" class="btn btn-primary btn-block" href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($t["id"]); ?>">详情</a>
                   <a role="button" class="btn btn-info btn-block" href="/index.php/Home/Bestforbaby/edititem/id/<?php echo ($t["id"]); ?>">编辑</a>
                 <a role="button" class="btn btn-default btn-block" href="/index.php/Home/Bestforbaby/deleteitem/id/<?php echo ($t["id"]); ?>">删除</a>
               </p>
                </div>
              </div>
            </div><?php endforeach; endif; ?>