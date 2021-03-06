<div class="btn-group">
	<a href="<?php echo site_urlc('links/create'); ?>" class='btn btn-primary' >  <i class="fa fa-plus"></i> 链接 </a>
</div>

<?php include_once 'inc_modules_path.php'; ?>

<div class="boxed">
	<div class="boxed-inner seamless">
		<table class="table table-striped table-hover select-list">
			<thead>
				<tr>
					<th class="width-small"><input id='selectbox-all' type="checkbox" > </th>
					<th> 排序</th>
					<th> <?php echo lang('thumb') ?></th>
					<th> <?php echo lang('title') ?></th>
					<th> <?php echo lang('link') ?></th>
					<th class="span1"> <?php echo lang('action') ?> </th>
				</tr>
			</thead>
			<tbody  class="sort-list">
				<?php foreach ($list as $v):?>
				<tr  data-id="<?php echo $v['id'] ?>" data-sort="<?php echo $v['sort_id'] ?>">
					<td><input class="select-it" type="checkbox" value="<?php echo $v['id']; ?>" ></td>
					<td> <a title='越大越前'><input type="text" class="sortid" value="<?php echo $v['sort_id']?>" data-id="<?php echo $v['id'] ?>"></a> </td>
					<td>
						<?php if ($v['thumb']): ?>
						<a class="fancybox-img" href="<?php echo UPLOAD_URL. str_replace('thumbnail/', '', $v['thumb']); ?>" title="<?php echo $v['title'] ?>">
							<img src="<?php echo UPLOAD_URL.$v['thumb'] ?>" alt="<?php echo $v['title'];?>">
						</a>
						<?php endif; ?>
					</td>
					<td> <?php echo $v['title'] ?></td>
					<td> <?php echo $v['link'] ?></td>
					<td>
						<div class="btn-group">
						<?php include 'inc_ui_audit.php'; ?>
						<a class='btn btn-small' href=" <?php echo site_urlc( $this->router->class.'/edit/'.$v['id']) ?> " title="<?php echo lang('edit') ?>"> <i class="fa fa-pencil"></i> <?php // echo lang('edit') ?></a>
							<a class='btn btn-danger btn-small btn-del' data-id="<?php echo $v['id'] ?>" href="#"  title="<?php echo lang('del') ?>"> <i class="fa fa-times"></i> <?php // echo lang('del') ?></a>
						</div>
					</td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>

<div class="btn-group">
	<a id='select-all' class='btn' href="#"> <i class=""></i> <?php echo lang('select_all') ?> </a>
	<a id='unselect-all' class='btn hide' href="#"> <i class=""></i> <?php echo lang('unselect') ?> </a>
	<a id="btn-del" class='btn btn-danger' href="#"> <i class="fa fa-times"></i> <?php echo lang('del') ?> </a>
</div>

<?php echo $pages; ?>

<script>
require(['adminer/js/ui'],function(ui){
	var links = {
		url_del:"<?php echo site_urlc('links/delete'); ?>"
		,url_show: "<?php echo site_urlc('links/show_ajax'); ?>"
		,url_audit: "<?php echo site_urlc('links/audit'); ?>"
		,url_sort: "<?php echo site_urlc('links/sortid'); ?>"
		,url_sort_change: "<?php echo site_urlc('links/sort_change'); ?>"
	};

	ui.fancybox_img();
	ui.btn_delete(links.url_del);	// 删除
	ui.btn_show(links.url_show); 	// 显隐
	ui.btn_audit(links.url_audit);	// 审核
	ui.sortable(links.url_sort);	// 排序
	ui.sort_change(links.url_sort_change); // input 排序
});
</script>
