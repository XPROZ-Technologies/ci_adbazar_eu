<?php $siteName = '';
$email = '...';
$configs = $this->session->userdata('configs');
if($configs){
    if(isset($configs['SITE_NAME'])) $siteName = $configs['SITE_NAME'];
    if(isset($configs['EMAIL_COMPANY'])) $email = $configs['EMAIL_COMPANY'];
} ?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.0
    </div>
    <strong>Bản quyền của <a href="#" target="_blank">...</a>.</strong> Phát triển bởi ...
    - <strong>Email: <a id="aSysEmail" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></strong>.
</footer>
</div>
<input type="text" hidden="hidden" id="rootPath" value="<?php echo ROOT_PATH; ?>">
<input type="text" hidden="hidden" id="siteName" value="<?php echo $siteName; ?>">
<input type="text" hidden="hidden" id="userImagePath" value="<?php echo USER_PATH; ?>">
<input type="text" hidden="hidden" id="errorCommonMessage" value="<?php echo ERROR_COMMON_MESSAGE; ?>">
<?php if(!$user) $user = $this->session->userdata('user');
if($user){ ?>
    <input type="text" hidden="hidden" id="userLoginId" value="<?php echo $user['id']; ?>">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="<?php echo $user['full_name'] ?>">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo empty($user['avatar']) ? NO_IMAGE : $user['avatar']; ?>">
    <input type="text" hidden="hidden" id="roleId" value="<?php echo $user['role_id']; ?>">
<?php } else { ?>
    <input type="text" hidden="hidden" id="userLoginId" value="0">
    <input type="text" hidden="hidden" id="fullNameLoginId" value="">
    <input type="text" hidden="hidden" id="avatarLoginId" value="<?php echo NO_IMAGE; ?>">
    <input type="text" hidden="hidden" id="roleId" value="0">
<?php } ?>
<noscript><meta http-equiv="refresh" content="0;" url="<?php echo base_url('backend/user/permission'); ?>" /></noscript>
<script src="assets/vendor/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/plugins/pace/pace.min.js"></script>
<script src="assets/vendor/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/plugins/fastclick/fastclick.js"></script>
<script src="assets/vendor/dist/js/app.min.js"></script>
<script src="assets/vendor/plugins/pnotify/pnotify.custom.min.js"></script>
<script src="assets/vendor/plugins/select2/select2.full.min.js"></script>
<script src="assets/vendor/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="assets/js/backend/common.js"></script>
<?php if(isset($scriptFooter)) outputScript($scriptFooter); ?>
</body>
</html>