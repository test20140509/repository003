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
		<div class="well" style="margin-top: 20px;">
		<?php echo $this->Form->create('Post', array('action'=>'index')); ?>
			<fieldset>
				<legend>検索</legend>
			</fieldset>
		<?php echo $this->Form->end('検索'); ?>
		</div>
	</div>
</div>