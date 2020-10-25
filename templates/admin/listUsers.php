<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

	<h1>Все пользователи</h1>

	<?php if (isset($results['errorMessage'])) { ?>
		<div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
	<?php } ?>
	
	<?php if (isset($results['statusMessage'])) { ?>
        <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
    <?php } ?>	
		
		<table>
			<tr>
				<th>Дата регистрации</th>
				<th>Логин</th>
				<th>Пароль</th>
				<th>Активность</th>
			</tr>
			
	<?php foreach ($results['users'] as $users ) { ?>
		<tr onclick="location='admin.php?action=editUsers&amp;usersId=<?php echo $users->id?>'">
			<td>
				<?php echo date('j M Y', $users->whenRegistred)?>
			</td>
            <td>
				<?php echo $users->login ?>
			</td>
            <td>
			<?php echo $users->password ?>				
			</td>
			<td>
				<?php echo $users->activeUser; ?>
			</td>
	<?php } ?></table> 	