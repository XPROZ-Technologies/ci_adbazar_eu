<?php echo form_open('frontend/site/changeLanguage', array('id' => 'languageForm')); ?>
    <select class="form-control" name="language_id" id="languageId" onchange="this.form.submit()">
        <?php foreach($this->Mconstants->languageIds as $k => $item): ?>
            <option value="<?php echo $k ?>" <?php echo $customer['language_id'] == $k ? 'selected':''; ?> ><?php echo $item; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="UrlOld" value="<?php echo $this->uri->uri_string(); ?>"/>
    <input type="submit" hidden="hidden" name="" value=""/>
<?php echo form_close(); ?>
<br>
<span><?php echo $this->lang->line('hello'); ?><span>
