<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/BSBA/back/functions.php');
    
    $data = getAll();
	$picsPath = '/wp-content/plugins/BSBA/storage';
?>

<div class="div_all">
      <h1>Upload pictures</h1>
	<div class="">
		<div class="div_form">
            <form method="POST" action="/wp-content/plugins/BSBA/back/upload.php" enctype="multipart/form-data">
                <div class="div_label">
                    <label for="img1">Picture 'BEFORE'</label>
                    <input type="file" id="img1" name="before">
                </div>
                <div class="div_label">
                    <label for="img2">Picture 'AFTER'</label>
                    <input type="file" id="img2" name="after">
                </div>
                <div class="div_label"> 
                    <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" require>
				</div>
                <div class="div_label">
					<button type="submit" class="btn btn-success" name="submit">Save</button>
                </div>
			</form>
        </div>
	</div>
		<div class="table">
			<table id="customers">
				<tr>
					<th>Before</th>
					<th>After</th>
					<th>Name</th>
					<th></th>
				</tr>
				<!-- Show pics -->
				<?php if($data): ?>
					<?php foreach($data as $item): ?>
						<tr>
							<td><img src="<?= $picsPath . '/before/' . $item->pic_name ?>" alt=""></td>
							<td><img src="<?= $picsPath . '/after/' . $item->pic_name ?>" alt=""></td>
							<td><?= getBlockName($item->pic_name) ?></td>
							<td style="text-align: center;">
							<input  type="hidden" value="<?= $item->id ?>" class="id_all">
							<button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="button_edit"><i class="fas fa-pen"></i></button>
							<a href="/wp-content/plugins/BSBA/back/delete.php?pic_id=<?= $item->id ?>" class="button_delete"><i class="fas fa-trash-alt"></i></a>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif;?>
				<!-- end show pics -->
			</table>
		</div>
	</div>
	<div align="center"><div class="button_edit"><i class="fas fa-trash-alt">[bsba-shortcode]</i></div></div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
      	</div>
		<form method="POST" action="/wp-content/plugins/BSBA/back/update.php" enctype="multipart/form-data">
      		<div class="modal-body">
      			<div class="item_form">
      				<label for="img1">Before</label>
      				<input type="file" name="before" id="img1">
				</div>
      			<div class="item_form">
      				<label for="img2">After</label>
      				<input type="file" name="after" id="img2">
      			</div>
      			<div class="item_form">
      				<label for="name">Name</label>
      				<input type="text" value="" name="name" class="name_edit form-control" id="name_edit">
      			</div>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        		<button type="submit" class="btn btn-success">Save changes</button>
      		</div>
  		</form>
    </div>
  </div>
</div>