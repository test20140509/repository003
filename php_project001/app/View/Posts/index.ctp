<div class="row-fluid">
	<div class="span9">
		<h2><?php echo $this->Html->link('Cake Blog', array('action' => 'index')); ?></h2>

		<p><?php echo $this->Paginator->counter(array('format' => __('total: {:count}, page: {:page}/{:pages}')));?></p>
		<table class="table">
			<tr>
				<th><?php echo $this->Paginator->sort('id', 'ID');?></th>
				<th><?php echo $this->Paginator->sort('title', 'タイトル');?></th>
				<th><?php echo $this->Paginator->sort('author_id', '作者');?></th>
				<th><?php echo $this->Paginator->sort('created', '作成日時');?></th>
			</tr>
			<?php foreach ($posts as $post): ?>
			<tr>
				<td><?php echo h($post['Post']['id']); ?></td>
				<td><?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?></td>
				<td><?php echo $this->Html->link($post['Author']['name'], array('controller' => 'authors', 'action' => 'view', $post['Author']['id'])); ?></td>
				<td><?php echo h($post['Post']['created']); ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php echo $this->Paginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="margin-top:20px;">
			<?php echo $this->Form->create('Post', array('action' => 'index')); ?>
			<fieldset>
				<legend>検索</legend>
				<?php echo $this->Form->input('author_id', array('label' => '作者名', 'class' => 'span12', 'multiple' => 'checkbox', 'default' => array_keys($authors))); ?>
				<div class="control-group">
					<?php echo $this->Form->label('keyword', 'キーワード', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $this->Form->text('keyword', array('class' => 'span12', 'placeholder' => 'タイトル、本文を対象に検索')); ?>
						<?php
						$options = array('and' => 'AND', 'or' => 'OR');
						$attributes = array('default' => 'and', 'class' => 'radio inline');
						echo $this->Form->radio('andor', $options, $attributes);
						?>
					</div>
				</div>
				<div class="control-group">
					<?php echo $this->Form->label('from', '作成期間', array('class' => 'control-label')); ?>
					<div class="controls">
						<?php echo $this->Form->text('from', array('class' => 'span6')); ?>
						<?php echo $this->Form->text('to', array('class' => 'span6')); ?>
					</div>
				</div>
			</fieldset>
			<?php echo $this->Form->end('検索'); ?>
		</div>
	</div>
</div>


<?php
$this->Html->css('http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css', null, array('block' => 'css'));
$this->Html->script(
	array('http://code.jquery.com/ui/1.9.1/jquery-ui.js',
		'http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js'),
	array('block' => 'script')
);
?>
<?php $this->start('script'); ?>
<script>
	$(function() {
		$("#PostFrom").datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			showOtherMonths: true,
			selectOtherMonths: true,
			onClose: function(s) {
				if (s) {
					$("#PostTo").datepicker("option", "minDate", s).focus();
				}
			}
		});
		$("#PostTo").datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			dateFormat: "yy-mm-dd",
			showOtherMonths: true,
			selectOtherMonths: true,
			onClose: function(s) {
				$("#PostFrom").datepicker("option", "maxDate", s);
			}
		});
	});
</script>
<?php $this->end(); ?>