<table class="table table-condensed table-bordered table-stripped">
	<thead>
		<tr>
			<th>Sn</th>
			<th>Student</th>
			<th>Feedback</th>
			<th>Feedback Type</th>
			<th>Parent Contact Required</th>
			<th>Parent Contacted</th>
			<th>Commented Date</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($feedbacks) && $feedbacks != NULL)
		{ $i= 1;
			foreach ($feedbacks as $feedback) 
			{ ?>
			<tr>
				<td><?= $i++ ?></td>
				<td><?= $feedback->st_fullname ?></td>
				<td><?= $feedback->comments ?></td>
				<td><?= $feedback->comment_type ?></td>
				<td><?= $feedback->parent_contact_required ? 'Yes' : '' ?></td>
				<td><?= $feedback->parent_contacted ? 'Yes' : '' ?></td>
				<td><?= $feedback->comment_date ?></td>
			</tr>
				<?php 
			}
		} ?>
	</tbody>
</table>                                                                                                                                                                                         