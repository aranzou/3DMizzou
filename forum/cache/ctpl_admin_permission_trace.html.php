<?php if (!defined('IN_PHPBB')) exit; $this->_tpl_include('simple_header.html'); ?>


<div style="background-color: #fff; padding: 10px; margin-top: 10px;" class="permissions">

	<?php if ($this->_rootref['U_BACK']) {  ?><a href="<?php echo (isset($this->_rootref['U_BACK'])) ? $this->_rootref['U_BACK'] : ''; ?>" style="float: <?php echo (isset($this->_rootref['S_CONTENT_FLOW_END'])) ? $this->_rootref['S_CONTENT_FLOW_END'] : ''; ?>;">&laquo; <?php echo ((isset($this->_rootref['L_BACK'])) ? $this->_rootref['L_BACK'] : ((isset($user->lang['BACK'])) ? $user->lang['BACK'] : '{ BACK }')); ?></a><?php } ?>


	<h3><?php echo ((isset($this->_rootref['L_TRACE_FOR'])) ? $this->_rootref['L_TRACE_FOR'] : ((isset($user->lang['TRACE_FOR'])) ? $user->lang['TRACE_FOR'] : '{ TRACE_FOR }')); ?>: <?php echo (isset($this->_rootref['PERMISSION_USERNAME'])) ? $this->_rootref['PERMISSION_USERNAME'] : ''; ?> / <?php if ($this->_rootref['FORUM_NAME']) {  echo (isset($this->_rootref['FORUM_NAME'])) ? $this->_rootref['FORUM_NAME'] : ''; ?> / <?php } echo (isset($this->_rootref['PERMISSION'])) ? $this->_rootref['PERMISSION'] : ''; ?> </h3>

	<br />

	<table cellspacing="1" class="type1">
	<thead>
	<tr>
		<th><?php echo ((isset($this->_rootref['L_TRACE_WHO'])) ? $this->_rootref['L_TRACE_WHO'] : ((isset($user->lang['TRACE_WHO'])) ? $user->lang['TRACE_WHO'] : '{ TRACE_WHO }')); ?></th>
		<th style="width: 50px;"><?php echo ((isset($this->_rootref['L_ACL_SETTING'])) ? $this->_rootref['L_ACL_SETTING'] : ((isset($user->lang['ACL_SETTING'])) ? $user->lang['ACL_SETTING'] : '{ ACL_SETTING }')); ?></th>
		<th style="width: 50px;"><?php echo ((isset($this->_rootref['L_TRACE_TOTAL'])) ? $this->_rootref['L_TRACE_TOTAL'] : ((isset($user->lang['TRACE_TOTAL'])) ? $user->lang['TRACE_TOTAL'] : '{ TRACE_TOTAL }')); ?></th>
		<th><?php echo ((isset($this->_rootref['L_INFORMATION'])) ? $this->_rootref['L_INFORMATION'] : ((isset($user->lang['INFORMATION'])) ? $user->lang['INFORMATION'] : '{ INFORMATION }')); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php $_trace_count = (isset($this->_tpldata['trace'])) ? sizeof($this->_tpldata['trace']) : 0;if ($_trace_count) {for ($_trace_i = 0; $_trace_i < $_trace_count; ++$_trace_i){$_trace_val = &$this->_tpldata['trace'][$_trace_i]; if (!($_trace_val['S_ROW_COUNT'] & 1)  ) {  ?><tr class="row4"><?php } else { ?><tr class="row3"><?php } ?>

		<td style="white-space: nowrap;"><strong><?php echo $_trace_val['WHO']; ?></strong></td>

		<?php if ($_trace_val['S_SETTING_NEVER']) {  ?>

			<td class="never"><?php echo ((isset($this->_rootref['L_ACL_NEVER'])) ? $this->_rootref['L_ACL_NEVER'] : ((isset($user->lang['ACL_NEVER'])) ? $user->lang['ACL_NEVER'] : '{ ACL_NEVER }')); ?></td>
		<?php } else if ($_trace_val['S_SETTING_YES']) {  ?>

			<td class="yes"><?php echo ((isset($this->_rootref['L_ACL_YES'])) ? $this->_rootref['L_ACL_YES'] : ((isset($user->lang['ACL_YES'])) ? $user->lang['ACL_YES'] : '{ ACL_YES }')); ?></td>
		<?php } else { ?>

			<td class="no"><?php echo ((isset($this->_rootref['L_ACL_NO'])) ? $this->_rootref['L_ACL_NO'] : ((isset($user->lang['ACL_NO'])) ? $user->lang['ACL_NO'] : '{ ACL_NO }')); ?></td>
		<?php } if ($_trace_val['S_TOTAL_NEVER']) {  ?>

			<td class="never"><?php echo ((isset($this->_rootref['L_ACL_NEVER'])) ? $this->_rootref['L_ACL_NEVER'] : ((isset($user->lang['ACL_NEVER'])) ? $user->lang['ACL_NEVER'] : '{ ACL_NEVER }')); ?></td>
		<?php } else if ($_trace_val['S_TOTAL_YES']) {  ?>

			<td class="yes"><?php echo ((isset($this->_rootref['L_ACL_YES'])) ? $this->_rootref['L_ACL_YES'] : ((isset($user->lang['ACL_YES'])) ? $user->lang['ACL_YES'] : '{ ACL_YES }')); ?></td>
		<?php } else { ?>

			<td class="no"><?php echo ((isset($this->_rootref['L_ACL_NO'])) ? $this->_rootref['L_ACL_NO'] : ((isset($user->lang['ACL_NO'])) ? $user->lang['ACL_NO'] : '{ ACL_NO }')); ?></td>
		<?php } ?>


		<td><?php echo $_trace_val['INFORMATION']; ?></td>
	</tr>
	<?php }} ?>

	<tr class="row2">
		<td style="white-space: nowrap;"><strong><?php echo ((isset($this->_rootref['L_TRACE_RESULT'])) ? $this->_rootref['L_TRACE_RESULT'] : ((isset($user->lang['TRACE_RESULT'])) ? $user->lang['TRACE_RESULT'] : '{ TRACE_RESULT }')); ?></strong></td>
		<td colspan="2" style="text-align: center;" class="<?php if ($this->_rootref['S_RESULT_NEVER']) {  ?>never<?php } else if ($this->_rootref['S_RESULT_YES']) {  ?>yes<?php } else { ?>no<?php } ?>">
		<?php if ($this->_rootref['S_RESULT_NEVER']) {  echo ((isset($this->_rootref['L_ACL_NEVER'])) ? $this->_rootref['L_ACL_NEVER'] : ((isset($user->lang['ACL_NEVER'])) ? $user->lang['ACL_NEVER'] : '{ ACL_NEVER }')); } else if ($this->_rootref['S_RESULT_YES']) {  echo ((isset($this->_rootref['L_ACL_YES'])) ? $this->_rootref['L_ACL_YES'] : ((isset($user->lang['ACL_YES'])) ? $user->lang['ACL_YES'] : '{ ACL_YES }')); } else { echo ((isset($this->_rootref['L_ACL_NO'])) ? $this->_rootref['L_ACL_NO'] : ((isset($user->lang['ACL_NO'])) ? $user->lang['ACL_NO'] : '{ ACL_NO }')); } ?>

		</td>
		<td><?php echo ((isset($this->_rootref['L_RESULTING_PERMISSION'])) ? $this->_rootref['L_RESULTING_PERMISSION'] : ((isset($user->lang['RESULTING_PERMISSION'])) ? $user->lang['RESULTING_PERMISSION'] : '{ RESULTING_PERMISSION }')); ?></td>
	</tr>
	</tbody>
	</table>

	<br />

</div>

<?php $this->_tpl_include('simple_footer.html'); ?>