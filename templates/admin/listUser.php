<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

	<h1>Все пользователи</h1>
	
	<h2><?php if($_SESSION['username'] !== ADMIN_USERNAME) {
		echo 'Извините! Добавлять и редактировать пользователей может только администратор!';	
	}?>
	</h2>
	

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
			
	<?php foreach ($results['user'] as $user ) { ?>
		<tr onclick="location='admin.php?action=editUser&amp;userId=<?php echo $user->id?>'">
			<td>
				<?php echo date('j M Y', $user->whenRegistred)?>
			</td>
            <td>
				<?php echo $user->login ?>
			</td>
            <td class="pass">
			<?php echo $user->password ?>				
			</td>
			<td>
				<?php echo $user->activeUser; ?>
			</td>
			
			<?php } ?>
		</table>
		
		<p><?php echo $results['totalRows']?> User<?php echo ( $results['totalRows'] != 1 ) ? 's' : '' ?> in total.</p>

        <p><a href="admin.php?action=newUser">Добавить нового пользователя</a></p>

<?php include "templates/include/footer.php" ?>