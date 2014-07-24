<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
    </div>
<?php endif; ?>

<div id="content">
  <div class="row">
      <div class="span7">
          <ul class="nav nav-tabs">
              <li class="active"><a href="<?php echo Yii::app()->baseUrl; ?>/home/index">Most Recent</a></li>
              <li class=""><a href="<?php echo Yii::app()->baseUrl; ?>/feed/open">Unanswered Questions</a></li>
              <li class="hidden-phone" style="float:right;width:100px;"><a href="<?php echo Yii::app()->baseUrl; ?>/index.php/topic/index" data-toggle="tooltip" data-placement="top" title="Customize your feed"><i class="icon-cog"><div style="padding-left:20px;font-size:10px;">Customize</div></i></a></li>
          </ul>
      </div> <!-- span7 Left Pane -->

      <div class="span4 offset1 hidden-phone">
          <div class="well" style="padding: 8px 0;">
              <div style="float:left">
                  <img border="1" style="padding: 8px 0px 8px 15px;max-width:100px;max-height:100px;" align="ABSMIDDLE" src="/mednet/images/profile/225.jpg" alt="profile picture"></div>
              <div class="namecard"><div style="float:left;padding-top:8px;"><a href="/mednet/index.php/user/user/view/id/225">Atif Khan</a><br>
                      <div class="p-namecard-position" style="color:#696e6f;">
                          <font style="color:black;font-size:12px;">Assistant Professor</font><br>Rutgers-Robert Wood Johnson Medical School        </div>
                  </div>
              </div><div style="clear:both"></div>
              <b>
                  <ul class="nav nav-list">
                      <li><a href="/mednet/index.php/user/user/view"><i class="icon-cog"></i> Settings</a></li>
                      <li><a href="/mednet/index.php/message/inbox/"><i class="icon-envelope"></i> Mail </a></li>
                      <li><a href="/mednet/index.php/answer/stats/"><i class="icon-signal"></i> Stats</a></li>

                      <!--Followers -->
                      <li><a href="/mednet/index.php/following/followers/225"><i class="icon-user"></i>Followers (<?php echo '1';?>)</a></li>        		</ul>
              </b></div><b> <!-- /well -->
          </b>
          <!-- Hot Topics -->

          <div class="well">
              <div class="boxhilight"><ul class="nav nav-list">
                      <div style="margin-bottom:10px;"><b>Most Active Topics</b></div>
                      <li><a href="/mednet/index.php/topic/80">Genitourinary Cancers (16)</a></li><li><a href="/mednet/index.php/topic/76">Gynecologic Cancers (15)</a></li><li><a href="/mednet/index.php/topic/98">Prostate Cancer (13)</a></li><li><a href="/mednet/index.php/topic/70">Breast Cancer (13)</a></li><li><a href="/mednet/index.php/topic/94">FAQ (13)</a></li>            </ul></div><div style="margin-top:10px;"><b>Browse all</b> <a class="last-line-action" href="/mednet/index.php/topic/index">Topics</a>, <a class="last-line-action" href="/mednet/index.php/user/user/index">People</a>, <a class="last-line-action" href="/mednet/index.php/question/index">Questions</a>
              </div>
          </div>

          <!-- Invitation Module -->

          <div class="well">
              <b>People You May Know</b><br><br>
              <!--You have <font color=red><b>(99)</b></font> invites remaining.</br></br> -->
              <div style="padding:3px;"> <button class="btn btn-success" style="margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px" onclick="javascript:invite('3117');" id="invite3117">Invite</button>
                  <div><img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="/mednet/images/profile/3117_30x30.jpg" alt="profile picture"></div><div style="float:left;max-width:45%" class="question-action"><a href="/mednet/index.php/user/user/view/id/3117">Neil Seif</a></div></div><div style="clear:both"></div><div style="padding:3px;"> <button class="btn btn-success" style="margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px" onclick="javascript:invite('356');" id="invite356">Invite</button>
                  <div><img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="/mednet/images/profile/356_30x30.jpg" alt="profile picture"></div><div style="float:left;max-width:45%" class="question-action"><a href="/mednet/index.php/user/user/view/id/356">Frank Vicini</a></div></div><div style="clear:both"></div><div style="padding:3px;"> <button class="btn btn-success" style="margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px" onclick="javascript:invite('2581');" id="invite2581">Invite</button>
                  <div><img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="/mednet/images/profile/2581_30x30.jpg" alt="profile picture"></div><div style="float:left;max-width:45%" class="question-action"><a href="/mednet/index.php/user/user/view/id/2581">Meena Moran</a></div></div><div style="clear:both"></div><div style="padding:3px;"> <button class="btn btn-success" style="margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px" onclick="javascript:invite('690');" id="invite690">Invite</button>
                  <div><img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="/mednet/images/profile/690_30x30.jpg" alt="profile picture"></div><div style="float:left;max-width:45%" class="question-action"><a href="/mednet/index.php/user/user/view/id/690">Adam Dickler</a></div></div><div style="clear:both"></div><div style="padding:3px;"> <button class="btn btn-success" style="margin-right:8px;margin-top:4px;float:left;height:auto;line-height:12px;width:54px;font-size:11px" onclick="javascript:invite('1804');" id="invite1804">Invite</button>
                  <div><img border="1" style="padding-right:8px;float:left;max-width:30px;max-height:30px;" src="/mednet/images/profile/1804_30x30.jpg" alt="profile picture"></div><div style="float:left;max-width:45%" class="question-action"><a href="/mednet/index.php/user/user/view/id/1804">Katherine Griem</a></div></div><div style="clear:both"></div><div style="margin-top:10px;"><br>
                  <a class="last-line-action" href="/mednet/index.php/peerSuggest/225">See More</a>		</div></div>


          <!--Followers -->
          <!-- Recommedned Questions -->

          <div class="well">
              <div class="boxhilight"><ul class="nav nav-list">
                      <b>Most Active Discussions</b><br>
                      <li><a href="/mednet/index.php/question/312"><div class="last-line-action">Is there a current 'standard of care' dose and fractionation in treating lung cancer with SBRT?</div><div class="p-pubitemdetail">There seem to be a lot of different fractionation schemes in the literature. Is ...</div></a></li><li><a href="/mednet/index.php/question/298"><div class="last-line-action">What is the best advice you received as a young attending?</div><div class="p-pubitemdetail"></div></a></li><li><a href="/mednet/index.php/question/195"><div class="last-line-action">What is a safe and effective dose and fractionation for palliating the head and neck primary?</div><div class="p-pubitemdetail">I have a patient with metastatic NSCLC and a concurrent head and neck primary.</div></a></li><li><a href="/mednet/index.php/question/245"><div class="last-line-action">Is there any data to support the use of hormone therapy in the post-prostatectomy setting?</div><div class="p-pubitemdetail"></div></a></li><li><a href="/mednet/index.php/question/243"><div class="last-line-action">What is the maximum V20 on ipsilateral lung that can be safely accepted for 3 or 4-field breast plans?</div><div class="p-pubitemdetail">V20 of 30% can be hard to attain if IMs are being treated.</div></a></li>            </ul></div>
          </div>

      </div> <!-- span4 Right Pane-->
  </div> <!-- row -->
</div> <!-- content -->
