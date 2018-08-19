<table class="table table-condensed table-bordered table-stripped">
	<thead>
		<tr>
			<th>Sn</th>
			<th>Feedback</th>
			<th>Feedback Type</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($feedbacks) && $feedbacks != NULL)
		{ $i= 1;
			foreach ($feedbacks as $feedback) 
			{ ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= $feedback->comments ?></td>
				<td><?= $feedback->comment_type ?></td>
			</tr>
				<?php 
			}
		} ?>
	</tbody>
</table>                                                                                                                                                                                         