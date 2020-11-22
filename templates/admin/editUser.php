<?php if($_SESSION['username'] !== 'admin') {
	header("Location: admin.php");
} ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/admin/include/header.php" ?>

	<h1><?php echo $results['pageTitle']?></h1>
	
	<form action="admin.php?action=<?php echo $results['formAction']?>" method="post">
		<input type="hidden" name="userId" value="<?php echo $results['user']->id ?>">
		
		<?php if (isset($results['errorMessage'])) { ?>
	        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
		<?php } ?>
		
		<ul>

            <li>
                <label for="login">Логин</label>
                <input type="text"
					   name="login" 
					   placeholder="Login of the user" 
					   required autofocus maxlength="255" 
					   value="<?php echo htmlspecialchars($results['user']->login)?>" />
            </li>

            <li>
                <label for="password">Пароль</label>
                <input type="password"
					   name="password" 
					   value="<?php echo htmlspecialchars($results['user']->password)?>" />
            </li>

            <li>
                <label for="activeUser">Активность</label>
				<input type="hidden"
					   name="activeUser"
					   value="0"/>
                <input type="checkbox"
					   name="activeUser" 
					   value="1"
					   <?php if(htmlspecialchars($results['user']->activeUser) != 0) echo 'checked'; ?>/>
            </li>

            <li>
                <label for="whenRegistred">Когда зарегистрирован</label>
                <input type="date" 
					   name="whenRegistred" 
					   placeholder="YYYY-MM-DD" 
					   required maxlength="10" 
					   value="<?php echo $results['user']->whenRegistred ? date( "Y-m-d", $results['user']->whenRegistred) : "" ?>" />
            </li>

            </ul>

            <div class="buttons">
              <input type="submit" name="saveChanges" value="Save Changes" />
              <input type="submit" formnovalidate name="cancel" value="Cancel" />
            </div>
			
	</form>
	
	<?php if ($results['user']->id) { ?>
        <p><a href="admin.php?action=deleteUser&amp;userId=<?php echo $results['user']->id ?>" onclick="return confirm('Delete This User?')">
                Удалить пользователя
           </a>
        </p>
    <?php } ?>
	  
<?php include "templates/include/footer.php" ?>