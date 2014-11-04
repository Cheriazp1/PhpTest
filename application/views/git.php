<table width="100%" border="1">
	<thead>
		<tr>
			<th>SHA</th>
			<th>Author</th>
			<th>Date</th>
			<th>Message</th>
			<th>Link</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($git as $v) { ?>
			<tr <?= (is_numeric(substr($v['sha'], -1))) ? "class='colored'" : "" ?>>
				<td><?= $v['sha'] ?></td>
				<td><?= $v['author'] ?></td>
				<td><?= $v['date'] ?></td>
				<td><?= $v['message'] ?></td>
				<td><a href="<?= $v['url'] ?>" target="_blank">Link</a></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

